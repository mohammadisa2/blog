<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\Blog;
use Filament\Tables;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use App\SlugService;
use App\Filament\Resources\BlogResource\Pages;
use OpenAI\Laravel\Facades\OpenAI;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Actions;
use Filament\Forms\Components\Actions\Action;

class BlogResource extends Resource
{
    protected static ?string $model = Blog::class;

    protected static ?string $navigationIcon = 'heroicon-s-pencil-square';

    protected static ?string $navigationGroup = 'Blogs';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn (Get $get, Set $set, ?string $old, ?string $state) => SlugService::generate(static::getModel()::findOrNew($get('id')), $get, $set, $old, $state)),
                        
                Forms\Components\TextInput::make('slug')
                    ->required()
                    ->readOnly()
                    ->maxLength(255),
                    
                Forms\Components\FileUpload::make('image')
                    ->image()
                    ->disk('public')
                    ->directory('blog-images')
                    ->columnSpanFull(),
                    
                Forms\Components\Select::make('category_blog_id')
                    ->relationship('category', 'name')
                    ->required(),
                    
                Forms\Components\TagsInput::make('tags')
                    ->separator(',')
                    ->suggestions(['laravel', 'php', 'filament'])
                    ->placeholder('Add a tag')
                    ->splitKeys(['Enter', ' ', ','])
                    ->reorderable(),

                Section::make('Content')
                    ->description('You can generate content using AI, just enter a prompt and click the button below.')
                    ->schema([
                        Forms\Components\MarkdownEditor::make('content')
                            ->required()
                            ->columnSpanFull()
                            ->fileAttachmentsDisk('public')
                            ->fileAttachmentsDirectory('blog-images')
                            ->fileAttachmentsVisibility('public'),
                        Forms\Components\Textarea::make('prompt')
                            ->columnSpanFull(),
                        Actions::make([
                            Action::make('Ai Content Generation')
                                ->icon('heroicon-m-code-bracket')
                                ->action(function (Get $get, Set $set): void {
                                    try {
                                        $prompt = $get('prompt');

                                        $response = OpenAI::chat()->create([
                                            'model' => 'gpt-3.5-turbo',
                                            'messages' => [
                                                ['role' => 'system', 'content' => 'You are a professional content writer specializing in creating well-structured, engaging blog posts. Write in markdown format.'],
                                                ['role' => 'user', 'content' => $prompt],
                                            ],
                                            'temperature' => 1.2,
                                            'max_tokens' => 1000,
                                        ]);

                                        $generatedContent = $response->choices[0]->message->content;
                                        
                                        $set('content', $generatedContent);

                                        // Show success notification
                                        \Filament\Notifications\Notification::make()
                                            ->title('Content Generated Successfully')
                                            ->success()
                                            ->send();

                                    } catch (\Exception $e) {
                                        // Show error notification
                                        \Filament\Notifications\Notification::make()
                                            ->title('Error Generating Content')
                                            ->body($e->getMessage())
                                            ->danger()
                                            ->send();
                                        
                                        // Log the error
                                        \Illuminate\Support\Facades\Log::error('AI Content Generation Error', [
                                            'error' => $e->getMessage(),
                                            'trace' => $e->getTraceAsString()
                                        ]);
                                    }
                                }),
                        ]),
                ]),

                Forms\Components\Toggle::make('is_published')
                    ->required(),
                    
                Forms\Components\DateTimePicker::make('published_at'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable(),
                Tables\Columns\TextColumn::make('category.name')
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_published')
                    ->boolean(),
                Tables\Columns\TextColumn::make('published_at')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('tags')
                    ->badge()
                    ->searchable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('category')
                    ->relationship('category', 'name'),
                Tables\Filters\TernaryFilter::make('is_published'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBlogs::route('/'),
            'create' => Pages\CreateBlog::route('/create'),
            'edit' => Pages\EditBlog::route('/{record}/edit'),
        ];
    }
}

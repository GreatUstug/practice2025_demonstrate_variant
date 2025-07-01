<?php

namespace App\Orchid\Screens;

use Orchid\Screen\Screen;
use Orchid\Screen\Fields\Input;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Actions\ModalToggle;
use App\Models\post;
use Illuminate\Http\Request;
use Orchid\Screen\TD;
use Orchid\Screen\Actions\Button;

use Post as GlobalPost;

class PostScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
{
    return [
        'posts' => post::latest()->get(),
    ];
}

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'PostsScreen';
    }

    public function description(): ?string
    {
        return "Forget hope, everyone who enters here";
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
{
    return [
        ModalToggle::make('Add Post')
            ->modal('postModal')
            ->method('create')
            ->icon('plus'),
    ];
}

    /**
     * The screen's layout elements.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
{
    return [
        Layout::table('posts', [
            TD::make('title'),
            TD::make('text'),
            TD::make('Delete')
            ->render(function (post $post) {
                return Button::make('Delete Post')
                ->confirm('After deleting, the post will be gone forever.')
                ->icon('trash')
                ->method('delete', ['post' => $post->id]);
            }),
            TD::make('Update Action')
            ->render(function (post $post) {
                return Button::make('Update Post')
                ->confirm('After updating, the post will hit different.')
                ->icon('pencil')
                ->method('update', ['post' => $post->id]);
            })
        ]),
        Layout::modal('postModal', Layout::rows([
            Input::make('post.text')
                ->title('text')
                ->placeholder('Enter post text')
                ->help('The text of the post to be created.'),
            Input::make('post.title')
                ->title('title')
                ->placeholder('Enter post title')
                ->help('The title of the post to be created.'),
        ]))
            ->title('Create Post')
            ->applyButton('Add Post'),
        Layout::modal('editModal', Layout::rows([
            Input::make('post.title')
                ->title('title'),
                //->value($post->title),
            Input::make('post.text')
                ->title('text'),
                //->value($post->text),
        ]))
    ->title('Edit Post')
    ->applyButton('Save Changes'),
    ];
}

public function create(Request $request)
{
    // Validate form data, save task to database, etc.
    $request->validate([
        'post.title' => 'required|max:255',
        'post.text' => 'required|max:255',
    ]);

    $post = new Post();
    $post->title = $request->input('post.title');
    $post->text = $request->input('post.text');
    $post->save();
}

public function delete(post $post)
{
    $post->delete();
}

public function update(Request $request, Post $post)
{
    $request->validate([
        'post.title' => 'required|max:255',
        'post.text' => 'required|max:255',
    ]);
    
    $post = Post::find($post->id);
    $post->title = $request->input('post.title');
    $post->text = $request->input('post.text');
    $post->save();
}

}

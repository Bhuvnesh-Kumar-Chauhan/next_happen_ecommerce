<?php

namespace App\Http\Controllers;

use App\Services\S3Service;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    protected $s3Service;

    public function __construct(S3Service $s3Service)
    {
        $this->s3Service = $s3Service;
    }

    public function index()
    {
        $images = $this->s3Service->listFiles('images');
        return view('images.index', compact('images'));
    }

    public function create()
    {
        return view('images.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $result = $this->s3Service->uploadFile($request->file('image'), 'images');

        if (!$result['success']) {
            return back()->with('error', 'Failed to upload image: ' . $result['message']);
        }

        return redirect()->route('images.index')->with('success', 'Image uploaded successfully');
    }

    public function show($path)
    {
        $url = $this->s3Service->getFileUrl($path);

        if (!$url) {
            abort(404);
        }

        return view('images.show', compact('url', 'path'));
    }

    public function edit($path)
    {
        $url = $this->s3Service->getFileUrl($path);

        if (!$url) {
            abort(404);
        }

        return view('images.edit', compact('url', 'path'));
    }

    public function update(Request $request, $path)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // First delete the old file
        $deleteResult = $this->s3Service->deleteFile($path);

        if (!$deleteResult['success']) {
            return back()->with('error', 'Failed to delete old image: ' . $deleteResult['message']);
        }

        // Upload the new file with the same path
        $uploadResult = $this->s3Service->uploadFile($request->file('image'), dirname($path));

        if (!$uploadResult['success']) {
            return back()->with('error', 'Failed to upload new image: ' . $uploadResult['message']);
        }

        return redirect()->route('images.index')->with('success', 'Image updated successfully');
    }
    public function destroy($path)
    {
        $result = $this->s3Service->deleteFile($path);

        if (!$result['success']) {
            return back()->with('error', 'Failed to delete image: ' . $result['message']);
        }

        return redirect()->route('images.index')->with('success', 'Image deleted successfully');
    }

    
}
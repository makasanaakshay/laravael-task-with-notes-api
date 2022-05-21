<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Resources\TaskResource;
use App\Http\Resources\TaskCollection;
use App\Interfaces\TaskRepositoryInterface;
use App\Repositories\FileRepository;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    use ApiResponseTrait;

    private TaskRepositoryInterface $taskRepository;

    public function __construct(TaskRepositoryInterface $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $tasks = $this->taskRepository->get($request->all());
        //send common response using task collection
        return $this->sendResponse(new TaskCollection($tasks));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(StoreTaskRequest $request, FileRepository $fileRepository)
    {
        $data = $request->all();

        //creating array for task create
        $details = [
            'user_id' => Auth::user()->id,
            'subject' => $data['subject'],
            'description' => $data['description'] ?? '',
            'start_date' => $data['start_date'],
            'due_date' => $data['due_date'],
            'status' => $data['status'] ?? 'New',
            'priority' => $data['priority'] ?? 'Low',
        ];

        //create task
        $task = $this->taskRepository->create($details);

        //add notes to tasks
        foreach ($data['notes'] as $i => $noteData) {
            $attachments = '';
            //check and upload attachments
            if (isset($noteData['attachments'])) {
                foreach ($noteData['attachments'] as $j => $attachment) {
                    $uploadedImage = $fileRepository->uploadFile($attachment, 'note');
                    $attachments .= asset($uploadedImage) . ',';
                }
            }
            //remove extra coma at last
            $attachments = rtrim($attachments, ',');

            //create note for tasks
            $task->notes()->create([
                'subject' => $noteData['subject'],
                'note' => $noteData['note'] ?? '',
                'attachments' => $attachments,
            ]);
        }

        //send common response task resource
        return $this->sendResponse([
            'task' => TaskResource::make($task->fresh())
        ]);
    }

}

<?php

require_once 'AppController.php';
require_once __DIR__ . '/../models/Meeting.php';
require_once __DIR__ . '/../repository/MeetingRepository.php';


class MeetingController extends AppController
{
    const MAX_FILE_SIZE = 1024 * 1024 * 1024;
    const SUPPORTED_TYPES = ['image/png', 'image/jpeg'];
    const UPLOAD_DIRECTORY = '/../public/uploads/';

    private $messages = [];
    private $meetingRepository;

    public function __construct()
    {
        parent::__construct();
        $this->meetingRepository = new MeetingRepository();
    }

    public function schedule()
    {
        $meetings = $this->meetingRepository->getMeetings();
        if ($_COOKIE["user"]) {
            $this->render('schedule', ['meetings' => $meetings]);
        }else
        $this->render('login', ['messages' => ['You have to be logged in!']]);

    }


    public function addMeeting()
    {
        if ($this->isPost() && is_uploaded_file($_FILES['file']['tmp_name']) && $this->validate($_FILES['file'])) {
            move_uploaded_file(
                $_FILES['file']['tmp_name'],
                dirname(__DIR__) . self::UPLOAD_DIRECTORY . $_FILES['file']['name']
            );

            $schedule = new Meeting($_POST['title'], $_POST['description'], $_FILES['file']['name']);
            $this->meetingRepository->addMeeting($schedule);

            return $this->render('schedule', [
                'meetings' => $this->meetingRepository->getMeetings(),
                'messages' => $this->message
            ]);
        }
        return $this->render('add-meeting', ['messages' => $this->message]);
    }


    private function validate(array $file): bool
    {
        if ($file['size'] > self::MAX_FILE_SIZE) {
            $this->message[] = 'File is too large for destination file system.';
            return false;
        }

        if (!isset($file['type']) || !in_array($file['type'], self::SUPPORTED_TYPES)) {
            $this->message[] = 'File type is not supported.';
            return false;
        }
        return true;
    }


}
<?php

namespace App\Handler;

use App\Command\CreateImageCommand;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class CreateImageHandler
{
    const extensions = [
        'image/jpeg' => 'jpeg',
        'image/png' => 'png',
        'image/gif' => 'gif',
    ];

    /**
     * @var string
     */
    private $kernelRootDir;

    public function __construct(string $kernelRootDir)
    {
        $this->kernelRootDir = $kernelRootDir;
    }

    public function handle(CreateImageCommand $createImageCommand)
    {
        [$type, $data] = explode(';', $createImageCommand->base64);
        [$junk, $data] = explode(',', $createImageCommand->base64);

        $image = base64_decode($data);
        $type = explode(':', $type);

        $extension = self::extensions[$type[1]];
        $filename = uniqid().".". $extension;
        $filePath = $this->kernelRootDir. "/../var/tmp/". $filename;

        file_put_contents($filePath, $data);
        $file = new UploadedFile($filePath, 'tukac', $type[1]);

        return $file->move($this->kernelRootDir. '/public/uploads/logos');
    }
}

<?php

namespace Dbseller\Aluraplay\Domain\Repository;

use Dbseller\Aluraplay\Domain\Model\Video;

interface VideoRepository
{
    public function getAllVideos(): array;
    public function getVideo(int $id): Video;
    public function saveVideo(Video $video): bool;
    public function editVideo(Video $video): bool;
    public function deleteVideo(int $id): bool;
}

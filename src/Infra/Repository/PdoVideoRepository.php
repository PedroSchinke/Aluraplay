<?php

namespace Dbseller\Aluraplay\Infra\Repository;

use PDO;
use Dbseller\Aluraplay\Domain\Repository\VideoRepository;
use Dbseller\Aluraplay\Domain\Model\Video;

class PdoVideoRepository implements VideoRepository
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    private function formObject($videoData): Video
    {
        $video = new Video(
            $videoData['id'],
            $videoData['url'],
            $videoData['title']
        );

        if ($videoData['image_path'] !== null) {
            $video->setFilePath($videoData['image_path']);
        }

        return $video;
    }

    public function getAllVideos(): array
    {
        $sql = "SELECT id, url, title, image_path FROM videos;";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $videosData = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $videosArray = array_map(function($video) {
            return $this->formObject($video);
        }, $videosData);

        return $videosArray;
    }

    public function getVideo(int $id): Video
    {
        $sql = "SELECT id, url, title, image_path FROM videos WHERE id = ?;";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(1, $id);
        $stmt->execute();
        $videoData = $stmt->fetch();

        $video = $this->formObject($videoData);

        return $video;
    }

    public function saveVideo(Video $video): bool
    {
        $sql = "INSERT INTO videos (url, title, image_path) VALUES (:url, :title, :image_path);";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':url', $video->getUrl());
        $stmt->bindValue(':title', $video->getTitle());
        $stmt->bindValue(':image_path', $video->getFilePath());

        return $stmt->execute();
    }

    public function editVideo(Video $video): bool
    {
        $updateImageSql = '';

        if ($video->getFilePath() !== null) {
            $updateImageSql = ', image_path = :image_path';
        }

        $sql = "UPDATE videos
                SET url = :url, title = :title $updateImageSql
                WHERE id = :id;";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':url', $video->getUrl());
        $stmt->bindValue(':title', $video->getTitle());
        $stmt->bindValue(':id', $video->getId(), PDO::PARAM_INT);
        
        if ($video->getFilePath() !== null) {
            $stmt->bindValue(':image_path', $video->getFilePath());
        }

        return $stmt->execute();
    }

    public function deleteVideo(int $id): bool
    {
        $sql = "DELETE FROM videos WHERE id = ?;";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(1, $id, PDO::PARAM_INT);

        return $stmt->execute();
    }
}
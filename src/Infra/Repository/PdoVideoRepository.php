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

        return $video;
    }

    public function getAllVideos(): array
    {
        $sql = "SELECT id, url, title FROM videos;";
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
        $sql = "SELECT id, url, title FROM videos WHERE id = ?;";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(1, $id);
        $stmt->execute();
        $videoData = $stmt->fetch();

        $video = $this->formObject($videoData);

        return $video;
    }

    public function saveVideo(Video $video): bool
    {
        $sql = "INSERT INTO videos (url, title) VALUES (:url, :title);";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':url', $video->getUrl());
        $stmt->bindValue(':title', $video->getTitle());

        return $stmt->execute();
    }

    public function editVideo(Video $video): bool
    {
        $sql = "UPDATE videos
                SET url = :url, title = :title
                WHERE id = :id;";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':url', $video->getUrl());
        $stmt->bindValue(':title', $video->getTitle());
        $stmt->bindValue(':id', $video->getId(), PDO::PARAM_INT);

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
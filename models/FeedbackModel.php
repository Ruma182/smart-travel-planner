<?php
/**
 * Model: feedback table access.
 */
class FeedbackModel extends Model
{
    public function getAll(int $providerId)
    {
        $s = $this->conn->prepare(
            "SELECT f.*, l.name, l.listing_type
             FROM feedback f
             LEFT JOIN listings l ON l.listing_id = f.listing_id
             WHERE f.provider_id=?
             ORDER BY f.created_at DESC"
        );

        $s->bind_param('i', $providerId);
        $s->execute();

        return $s->get_result();
    }

    public function saveReply(int $id, int $providerId, string $reply)
    {
        $s = $this->conn->prepare(
            "UPDATE feedback
             SET reply=?
             WHERE feedback_id=?
             AND provider_id=?"
        );

        $s->bind_param(
            'sii',
            $reply,
            $id,
            $providerId
        );

        return $s->execute();
    }

    public function avgRating(int $providerId)
    {
        $stmt = $this->conn->prepare(
            "SELECT COALESCE(ROUND(AVG(rating), 1), 0)
             FROM feedback
             WHERE provider_id = ?"
        );

        $stmt->bind_param('i', $providerId);
        $stmt->execute();

        $row = $stmt->get_result()->fetch_row();

        return $row[0] ?? 0;
    }

    public function count(int $providerId)
    {
        $stmt = $this->conn->prepare(
            "SELECT COUNT(*)
             FROM feedback
             WHERE provider_id = ?"
        );

        $stmt->bind_param('i', $providerId);
        $stmt->execute();

        $row = $stmt->get_result()->fetch_row();

        return $row[0] ?? 0;
    }
}

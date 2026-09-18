<?php
/**
 * Model: notifications table access.
 */
class NotificationModel extends Model
{
    public function markAllRead(int $providerId)
    {
        $s = $this->conn->prepare(
            "UPDATE notifications
             SET is_read=1
             WHERE provider_id=?"
        );

        $s->bind_param('i', $providerId);

        return $s->execute();
    }

    public function getAll(int $providerId)
    {
        $s = $this->conn->prepare(
            "SELECT *
             FROM notifications
             WHERE provider_id=?
             ORDER BY created_at DESC"
        );

        $s->bind_param('i', $providerId);
        $s->execute();

        return $s->get_result();
    }

    public function create(int $providerId, int $bookingId, string $message)
    {
        $notification = $this->conn->prepare(
            "INSERT INTO notifications
             (provider_id, booking_id, message)
             VALUES (?, ?, ?)"
        );

        $notification->bind_param(
            'iis',
            $providerId,
            $bookingId,
            $message
        );

        return $notification->execute();
    }
}

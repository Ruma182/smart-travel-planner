<?php
/**
 * Model: bookings table access.
 */
class BookingModel extends Model
{
    public function getRecent(int $providerId, int $limit = 5)
    {
        $recent = $this->conn->prepare(
            "SELECT b.*, l.name, l.listing_type
             FROM bookings b
             JOIN listings l ON l.listing_id = b.listing_id
             WHERE b.provider_id = ?
             ORDER BY b.created_at DESC
             LIMIT ?"
        );

        $recent->bind_param('ii', $providerId, $limit);
        $recent->execute();

        return $recent->get_result();
    }

    public function getAll(int $providerId)
    {
        $stmt = $this->conn->prepare(
            "SELECT b.*, l.name, l.listing_type
             FROM bookings b
             JOIN listings l ON l.listing_id = b.listing_id
             WHERE b.provider_id = ?
             ORDER BY b.created_at DESC"
        );

        $stmt->bind_param('i', $providerId);
        $stmt->execute();

        return $stmt->get_result();
    }

    public function getOne(int $id, int $providerId)
    {
        $stmt = $this->conn->prepare(
            "SELECT b.*, l.name
             FROM bookings b
             JOIN listings l ON l.listing_id = b.listing_id
             WHERE b.booking_id = ?
             AND b.provider_id = ?
             LIMIT 1"
        );

        $stmt->bind_param('ii', $id, $providerId);
        $stmt->execute();

        return $stmt->get_result()->fetch_assoc();
    }

    public function updateStatus(int $id, int $providerId, string $status)
    {
        $update = $this->conn->prepare(
            "UPDATE bookings
             SET status = ?
             WHERE booking_id = ?
             AND provider_id = ?
             AND status = 'Pending'"
        );

        $update->bind_param(
            'sii',
            $status,
            $id,
            $providerId
        );

        $update->execute();

        return $update->affected_rows;
    }

    public function countByStatus(int $providerId, string $status)
    {
        $stmt = $this->conn->prepare(
            "SELECT COUNT(*)
             FROM bookings
             WHERE provider_id = ?
             AND status = ?"
        );

        $stmt->bind_param('is', $providerId, $status);
        $stmt->execute();

        $row = $stmt->get_result()->fetch_row();

        return $row[0] ?? 0;
    }

    public function sumRevenue(int $providerId)
    {
        $stmt = $this->conn->prepare(
            "SELECT COALESCE(SUM(total_amount), 0)
             FROM bookings
             WHERE provider_id = ?
             AND status IN ('Confirmed', 'Completed')"
        );

        $stmt->bind_param('i', $providerId);
        $stmt->execute();

        $row = $stmt->get_result()->fetch_row();

        return $row[0] ?? 0;
    }
}

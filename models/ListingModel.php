<?php
/**
 * Model: listings table access.
 */
class ListingModel extends Model
{
    public function getAllByProvider(int $providerId)
    {
        $stmt = $this->conn->prepare(
            "SELECT * FROM listings
             WHERE provider_id=?
             ORDER BY created_at DESC"
        );

        $stmt->bind_param('i', $providerId);
        $stmt->execute();

        return $stmt->get_result();
    }

    public function getOne(int $id, int $providerId)
    {
        $s = $this->conn->prepare(
            "SELECT * FROM listings WHERE listing_id=? AND provider_id=?"
        );

        $s->bind_param('ii', $id, $providerId);
        $s->execute();

        return $s->get_result()->fetch_assoc();
    }

    public function create(int $providerId, string $type, string $name, string $destination, string $description, float $price, int $availability, ?string $image)
    {
        $sql = "INSERT INTO listings
                (provider_id, listing_type, name, destination, description, price, availability, image)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $this->conn->prepare($sql);

        $stmt->bind_param(
            'issssdis',
            $providerId,
            $type,
            $name,
            $destination,
            $description,
            $price,
            $availability,
            $image
        );

        return $stmt->execute();
    }

    public function update(int $id, int $providerId, string $type, string $name, string $destination, string $description, float $price, int $availability, ?string $image)
    {
        $u = $this->conn->prepare(
            "UPDATE listings
             SET listing_type=?,
                 name=?,
                 destination=?,
                 description=?,
                 price=?,
                 availability=?,
                 image=?
             WHERE listing_id=?
             AND provider_id=?"
        );

        $u->bind_param(
            'ssssdisii',
            $type,
            $name,
            $destination,
            $description,
            $price,
            $availability,
            $image,
            $id,
            $providerId
        );

        return $u->execute();
    }

    public function delete(int $id, int $providerId)
    {
        $s = $this->conn->prepare(
            "DELETE FROM listings WHERE listing_id=? AND provider_id=?"
        );

        $s->bind_param('ii', $id, $providerId);

        return $s->execute();
    }

    public function count(int $providerId)
    {
        $stmt = $this->conn->prepare("SELECT COUNT(*) FROM listings WHERE provider_id = ?");
        $stmt->bind_param('i', $providerId);
        $stmt->execute();

        $row = $stmt->get_result()->fetch_row();

        return $row[0] ?? 0;
    }

    public function sumAvailable(int $providerId)
    {
        $stmt = $this->conn->prepare(
            "SELECT COALESCE(SUM(availability), 0)
             FROM listings
             WHERE provider_id = ?
             AND status = 'active'"
        );

        $stmt->bind_param('i', $providerId);
        $stmt->execute();

        $row = $stmt->get_result()->fetch_row();

        return $row[0] ?? 0;
    }

    public function reduceAvailability(int $listingId, int $providerId, int $guests)
    {
        $query = $this->conn->prepare(
            "UPDATE listings
             SET availability = GREATEST(availability - ?, 0)
             WHERE listing_id = ?
             AND provider_id = ?"
        );

        $query->bind_param(
            'iii',
            $guests,
            $listingId,
            $providerId
        );

        return $query->execute();
    }
}

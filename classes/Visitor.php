<?php

require_once __DIR__ . '/../config/Logger.php';

class Visitor {

    private $visitorId;
    private $name;
    private $date;
    private $time;
    private $reason;
    private $action_taken;

    function __construct($name, $date, $time, $reason, $action_taken) {
        $this->name = $name;
        $this->date = $date;
        $this->time = $time;
        $this->reason = $reason;
        $this->action_taken = $action_taken;
    }

    public function addVisitor($con) {
        try {
            $query = "INSERT INTO visitors (name, date, time, reason, action_taken) VALUES (?, ?, ?, ?, ?)";
            $stmt = $con->prepare($query);
            $stmt->bindParam(1, $this->name);
            $stmt->bindParam(2, $this->date);
            $stmt->bindParam(3, $this->time);
            $stmt->bindParam(4, $this->reason);
            $stmt->bindParam(5, $this->action_taken);
            $result = $stmt->execute();
            
            if (!$result) {
                Logger::error("Failed to insert visitor", ['error' => $stmt->errorInfo()]);
            }
            
            return $result;
        } catch (PDOException $ex) {
            Logger::error("Database error in addVisitor: " . $ex->getMessage());
            return false;
        }
    }

    public static function getAllVisitors($con) {
        try {
            $query = "SELECT * FROM visitors ORDER BY date DESC, time DESC";
            $stmt = $con->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $ex) {
            Logger::error("Database error in getAllVisitors: " . $ex->getMessage());
            return false;
        }
    }

    public static function getVisitorsPaginated($con, $limit = 10, $offset = 0, $search = null, $filter = null) {
        try {
            $query = "SELECT * FROM visitors WHERE 1=1";
            $params = [];
            
            // Add search condition
            if ($search) {
                $query .= " AND (name LIKE ? OR reason LIKE ?)";
                $searchTerm = "%{$search}%";
                $params[] = $searchTerm;
                $params[] = $searchTerm;
            }
            
            // Add filter condition
            if ($filter && in_array($filter, ['checked_in', 'checked_out', 'reported'])) {
                $query .= " AND action_taken = ?";
                $params[] = $filter;
            }
            
            $query .= " ORDER BY date DESC, time DESC LIMIT ? OFFSET ?";
            $params[] = $limit;
            $params[] = $offset;
            
            $stmt = $con->prepare($query);
            
            // Bind parameters
            foreach ($params as $index => $value) {
                $type = is_int($value) ? PDO::PARAM_INT : PDO::PARAM_STR;
                $stmt->bindValue($index + 1, $value, $type);
            }
            
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $ex) {
            Logger::error("Database error in getVisitorsPaginated: " . $ex->getMessage());
            return false;
        }
    }

    public static function getTotalVisitorsCount($con, $search = null, $filter = null) {
        try {
            $query = "SELECT COUNT(*) as count FROM visitors WHERE 1=1";
            $params = [];
            
            // Add search condition
            if ($search) {
                $query .= " AND (name LIKE ? OR reason LIKE ?)";
                $searchTerm = "%{$search}%";
                $params[] = $searchTerm;
                $params[] = $searchTerm;
            }
            
            // Add filter condition
            if ($filter && in_array($filter, ['checked_in', 'checked_out', 'reported'])) {
                $query .= " AND action_taken = ?";
                $params[] = $filter;
            }
            
            $stmt = $con->prepare($query);
            
            foreach ($params as $index => $value) {
                $stmt->bindValue($index + 1, $value);
            }
            
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['count'];
        } catch (PDOException $ex) {
            Logger::error("Database error in getTotalVisitorsCount: " . $ex->getMessage());
            return 0;
        }
    }

    public static function editVisitor($con, $id, $name, $date, $time, $reason, $action_taken) {
        try {
            $query = "UPDATE visitors SET name = ?, date = ?, time = ?, reason = ?, action_taken = ? WHERE visitorId = ?";
            $stmt = $con->prepare($query);
            $stmt->bindParam(1, $name);
            $stmt->bindParam(2, $date);
            $stmt->bindParam(3, $time);
            $stmt->bindParam(4, $reason);
            $stmt->bindParam(5, $action_taken);
            $stmt->bindParam(6, $id);
            $result = $stmt->execute();
            if (!$result) {
                error_log("Database error in editVisitor: " . implode(", ", $stmt->errorInfo()));
            }
            return $result;
        } catch (PDOException $ex) {
            error_log("Database error in editVisitor: " . $ex->getMessage());
            return false;
        }
    }

    public static function deleteVisitor($con, $visitorId) {
        try {
            $query = "DELETE FROM visitors WHERE visitorId = ?";
            $stmt = $con->prepare($query);
            $stmt->bindParam(1, $visitorId);
            return $stmt->execute();
        } catch (PDOException $ex) {
            error_log("Database error in deleteVisitor: " . $ex->getMessage());
            return false;
        }
    }

    public static function getVisitorById($con, $visitorId) {
        try {
            $query = "SELECT * FROM visitors WHERE visitorId = ?";
            $stmt = $con->prepare($query);
            $stmt->bindParam(1, $visitorId);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $ex) {
            error_log("Database error: " . $ex->getMessage());
            return false;
        }
    }

    public static function getCheckedInCount($con) {
        return self::getCountByActionTaken($con, 'checked_in');
    }

    public static function getCheckedOutCount($con) {
        return self::getCountByActionTaken($con, 'checked_out');
    }

    public static function getReportedCount($con) {
        return self::getCountByActionTaken($con, 'reported');
    }

    public static function getTotalVisitorsCount($con) {
        try {
            $query = "SELECT COUNT(*) as count FROM visitors WHERE MONTH(date) = MONTH(CURRENT_DATE()) AND YEAR(date) = YEAR(CURRENT_DATE())";
            $stmt = $con->prepare($query);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['count'];
        } catch (PDOException $ex) {
            error_log("Database error: " . $ex->getMessage());
            return false;
        }
    }

    private static function getCountByActionTaken($con, $actionTaken) {
        try {
            $query = "SELECT COUNT(*) as count FROM visitors WHERE action_taken = ? AND MONTH(date) = MONTH(CURRENT_DATE()) AND YEAR(date) = YEAR(CURRENT_DATE())";
            $stmt = $con->prepare($query);
            $stmt->bindParam(1, $actionTaken);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['count'];
        } catch (PDOException $ex) {
            error_log("Database error: " . $ex->getMessage());
            return false;
        }
    }

    public static function getRecentVisitors($con, $limit = 10) {
        try {
            $query = "SELECT * FROM visitors ORDER BY date DESC, time DESC LIMIT ?";
            $stmt = $con->prepare($query);
            $stmt->bindParam(1, $limit, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $ex) {
            error_log("Database error: " . $ex->getMessage());
            return false;
        }
    }

}

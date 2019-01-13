<?php

class Brakes
{
    /**
     * Get all params or concret params by paramsId.
     *
     * @param bool $paramsId
     * @param $status
     * @return string
     */
    public function getParams($paramsId, bool $status)
    {
        if ($paramsId && $status === true) {
            $someParams = $this->getParamsById($paramsId);

            if (!empty($someParams)) {
                $result = $someParams;
            } else {
                $errorMessage = $this->generateErrors(' invalid Paramether paramsID');
                $result = $errorMessage;
            }
        }

        return $result;
    }

    /**
     * Generate errors for system.
     *
     * @param $message
     * @return string
     */
    protected function generateErrors($message = false)
    {
        if (!empty($message)) {
            $errors = 'System errors -' . $message;
        } else {
            $errors = 'Invalidate fatall errors';
        }

        return $errors;
    }

    /**
     * Get all steering params from db.
     *
     * @param bool $status
     * @return string|void
     */
    public function getAllParams(bool $status)
    {
        if ($status) {
            $allParams = $this->getAllSteeringParams();
            if (!empty($allParams)) {
                $result = $allParams;
            } else {
                $errorMessage = $this->generateErrors(' all params for Steerin model empty!');
                $result = $errorMessage;
            }
        } else {
            $result = $this->generateErrors();
        }

        return $result;
    }

    /**
     * Get all params from db = table steering
     */
    protected function getAllSteeringParams()
    {
        $db = Db::getConnection();
        $steering = $db->query('SELECT * FROM steering order by id desc limit 1000')
            ->fetchAll(PDO::FETCH_ASSOC);

        Db::closeDbConnection($db);

        return $steering;
    }

    /**
     * Get params by id from db = table steering
     *
     * @param $paramId
     * @return array
     */
    protected function getParamsById(string $paramId)
    {
        $db = Db::getConnection();
        $steering = $db->query('SELECT * FROM steering WHERE id =' . $paramId)
            ->fetchAll(PDO::FETCH_ASSOC);
        Db::closeDbConnection($db);

        return $steering;
    }

    /**
     * Create new params and save to data base.
     *
     * @param $params
     * @return bool
     */
    public function createNewParams($params)
    {
        if (isset($params['name'], $params['type'], $params['value'], $params['priority'])) {
            $db = Db::getConnection();
            $sql = 'INSERT INTO steering (name, type, value, priority) '
                . 'VALUES (:name, :type, :value, :priority)';
            // Save nd get params from table
            $result = $db->prepare($sql);
            $result->bindParam(':name', base64_encode($params['name']), PDO::PARAM_STR);
            $result->bindParam(':type', base64_encode($params['type']), PDO::PARAM_STR);
            $result->bindParam(':value', base64_encode($params['value']), PDO::PARAM_STR);
            $result->bindParam(':priority', base64_encode($params['priority']), PDO::PARAM_INT);
            Db::closeDbConnection($db);

            return $result->execute();
        }

        return false;
    }

    /**
     * Update params in table steering.
     *
     * @param array $changeParams
     * @return bool
     */
    public function сhangeParams($changeParams)
    {
        if (isset($changeParams['name'], $changeParams['value'])) {
            $db = Db::getConnection();
            $sql = "UPDATE steering SET value=:value WHERE name=:name";
            // Save nd get params from table
            $result = $db->prepare($sql);
            $result->bindParam(':name', $changeParams['name'], PDO::PARAM_STR);
            $result->bindParam(':value', $changeParams['value'], PDO::PARAM_STR);
            Db::closeDbConnection($db);

            return $result->execute();
        }

        return false;
    }

    /**
     * Delete params from db where name = request name
     *
     * @param string $deleteParams
     * @return bool
     */
    public function deleteParams($deleteParams)
    {
        if (!empty($deleteParams)) {
            $db = Db::getConnection();
            $queryDeleteParams = 'DELETE FROM steering WHERE name = :name';
            // delete params from table steering
            $delete = $db->prepare($queryDeleteParams);
            $delete->bindParam(':name', $deleteParams, PDO::PARAM_STR);
            $delete->execute();
            // delete this params from information system
            Information::deleteParamInformation('steering');

            Db::closeDbConnection($db);

            return true;
        }
        return false;
    }

}

<?php

class database extends \mysqli 
{
  function __construct ($dbName)
  {
    parent::__construct('127.0.0.1', ini_get("mysqli.default_user"), ini_get("mysqli.default_pw"), $dbName);
    if (mysqli_connect_error())
    {
      throw new \Exception(sprintf("Can't connect to MySQL Server. Errorcode: (%s) %s\n", mysqli_connect_errno(), mysqli_connect_error()));
    }
  }

  function returnResults ($sql)
  {
    $results = $this->query($sql);

    if (is_object($results))
    {
      if ($results->num_rows)
      {
        while ($row = $results->fetch_assoc())
        {
          $res[] = $row;
        }
        $this->close();
        return $res;
      }
    }
  }
}
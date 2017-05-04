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

  function query ($sql, ...$args)
  {
      foreach ($args as &$value)
      {
        $value = $this->escape_string($value);
      }

      $sql = vsprintf($sql, $args);

      $result = parent::query($sql);
      if (!$result)
      {
        error_log("complete query: " . $sql);
        throw new \Exception(sprintf("Error in query \"%s\". Error message: %s\n", $sql, $this->error));
      }
      return $result;
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
        return $res;
      }
    }
  }

  function returnResultsIndexed ($sql, $index)
  {
    $results = $this->query($sql);

    if (is_object($results))
    {
      if ($results->num_rows)
      {
        while ($row = $results->fetch_assoc())
        {
          $res[$row[$index]] = $row;
        }
        return $res;
      }
    }
  }

  function escape_string ($str)
  {
    return parent::real_escape_string($str);
  }
}
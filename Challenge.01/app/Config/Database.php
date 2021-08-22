<?php

namespace App\Config;

class Database
{

	private $servername;
	private $username;
	private $password;
	private $dbname;
	private $conn;

    // get the database connection
    public function getConnection(){

        try
		{
            $servername = env("DB_HOST");
            $username = env("DB_USERNAME");
            $password = env("DB_PASSWORD");
            $dbname = env("DB_DATABASE");
            $conn = mysqli_connect($servername, $username, $password, $dbname);
            // Check connection
            if (!$conn) 
			{
            	exit("Connection failed: " . mysqli_connect_error());
            } 

        }
		catch(PDOException $exception)
		{
            echo "Connection error: " . $exception->getMessage();
        }
        return $conn;
    }

    // generate the reports schema
    public function getReports($start_date = null, $end_date = null)
	{
		$params = array();

		$sql = 'SELECT
		f.company AS Company,
		SUM(CASE WHEN LOWER(f.ent_name) = "basic" THEN f.cnt_users ELSE 0 END) AS Basic,
		SUM(CASE WHEN LOWER(f.ent_name) = "plus" THEN f.cnt_users ELSE 0 END) AS Plus,
		SUM(CASE WHEN LOWER(f.ent_name) = "premium" THEN f.cnt_users ELSE 0 END) AS Premium
		FROM
		(
		SELECT
		COUNT(a.email) AS cnt_users,
		a.sub_code,
		a.company,
		a.ent_name
		FROM
			(
			SELECT 
			DISTINCT SUBSTRING_INDEX(p.code, \'_\', 2) AS sub_code,
			s.*,
			p.id AS pl_id,
			p.company_id AS pl_comp_id,
			p.entitlement_id AS pl_ent_id,
			p.code,
			p.period,
			p.include_free_trial,
			p.ent_name,
			p.ent_id,
			p.ent_comp_id
			FROM
				(
				SELECT 
				DISTINCT su.*,
				u.name AS sub_user,
				u.email,
				c.name AS company
				FROM
					subscriptions su
				INNER JOIN users u ON su.user_id = u.id
				INNER JOIN companies c ON su.company_id = c.id
				WHERE su.expired_at >= NOW()';
				if (!empty($start_date) && !empty($end_date))
				{
					$sql .= 'and date(su.created_at) >= "'.$start_date.'" and date(su.created_at) <= "'.$end_date.'" ';
				}

				$sql .= ' ) s
			LEFT JOIN
				(
				SELECT
					pl.*,
					e.id AS ent_id,
					e.name AS ent_name,
					e.company_id AS ent_comp_id
				FROM plans pl
				INNER JOIN entitlements e ON e.company_id = pl.company_id AND e.id = pl.entitlement_id
				) p
			ON
				p.company_id = s.company_id AND p.id = s.plan_id
			) a
			GROUP BY
				a.sub_code,
				a.company,
				a.ent_name
			) f
		GROUP BY
			f.company';

		$conn = Database::getConnection();
		$result = mysqli_query($conn, $sql);
          
		return $result;
	}
}
?>
<?php
require_once "../classes/Database.php";

/**
 * Created by PhpStorm.
 * User: denes
 * Date: 28-May-17
 * Time: 5:19 PM
 */
class NewWorkDayHandler
{
    public function createWorkDay($data, $work_day_date)
    {
        $_SESSION['message'] = "Nu ati introdus datele corect in campurile obligatorii:";
        $array = $data;
        $backup_array = null;
        $last = 1;
        $success = true;

        foreach ($array as $key_row => $row) {
            if (array_sum($array[$key_row]) == 0) {
                unset($array[$key_row]);
                continue;
            }
            foreach ($row as $data_key => $data_id) {
                if ($data_id === "0") {
                    $backup_array['success'] = false;
                    $success = false;
                    $resp['success'] = false;
                    if ($data_key == "employee" && $data_id == 0) {
                        $_SESSION['message'] .= "<br> - nu ai introdus lucratorul in randul <strong>" . $last . "</strong>";
                        $backup_array['icon'][$last][$data_key] = "<span class=\"glyphicon glyphicon-warning-sign form-control-feedback\" aria-hidden=\"true\"></span>";
                        $backup_array['status'][$last][$data_key] = "has-warning has-feedback";
                    } elseif ($data_key == "loc_activitate" && $data_id == 0) {
                        $_SESSION['message'] .= "<br> - nu ai ales locul activitatii in randul <strong>" . $last . "</strong>";
                        $backup_array['icon'][$last][$data_key] = "<span class=\"glyphicon glyphicon-remove form-control-feedback\" aria-hidden=\"true\"></span>";
                        $backup_array['status'][$last][$data_key] = "has-error has-feedback";
                    }
                } else {
                    $backup_array['icon'][$last][$data_key] = "<span class=\"glyphicon glyphicon-ok form-control-feedback\" aria-hidden=\"true\"></span>";
                    $backup_array['status'][$last][$data_key] = "has-success has-feedback";
                }
            }
            $backup_array[$last] = $data[$key_row];
            $last++;
        }

        if ($success) {

            $backup_array['last'] = $last;
            $this->add_work_day($backup_array, $work_day_date);
            $_SESSION['message'] = "Datele au fost adaugate cu success";
            $_SESSION['status'] = "success";
            $_SESSION['icon'] = "glyphicon-ok";
          //  $backup_array = ['employee' => 0, 'loc_activitate' => 0, 'comment' => null];
            $backup_array['last'] = 1;
            $backup_array['success'] = true;
        } else {
            $_SESSION['status'] = "danger";
            $_SESSION['icon'] = "glyphicon-exclamation-sign";
            $backup_array['last'] = $last;
            $backup_array[$last] = ['employee' => 0, 'loc_activitate' => 0, 'comment' => null];
        }
        return $backup_array;
    }

    // adauaga zi noua in BD in new_day.php
    private function add_work_day($array, $date)
    {
        $db = Database::getInstance();
        $mysqli = $db->getConnection();
        for ($i = 1; $i < $array['last']; $i++) {
            $query = "INSERT INTO cozagro_db.work_days (id_angajat, id_loc_activitate, comment, submission_date, deleted) VALUES ( {$array[$i]['employee']} , {$array[$i]['loc_activitate']} , '{$array[$i]['comment']}' , '{$date}', 0)";
            $mysqli->query($query);
        }
    }
}

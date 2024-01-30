<?php
if (!function_exists('formatMinutesToHours')) {
    function formatMinutesToHours($minutes)
    {
        $hours = floor($minutes / 60);
        $remainingMinutes = $minutes % 60;

        $result = sprintf("%02d:%02d", $hours, $remainingMinutes);
        $result .= " jam " . $remainingMinutes . " menit";

        return $result;
    }
}
?>

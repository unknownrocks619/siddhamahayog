<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>canada Attendance</title>
    <link href="//cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="//cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
</head>
<body>
    <table border="1" width="100%" id="attendance">
        <thead>
            <tr>
                <th>Full name</th>
                <th>Attendance</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
        @php
            foreach ($get_all_meeting_record as $attendance) {
                echo "<tr>";
                    echo "<td>";
                        echo $attendance->user_detail->full_name();
                    echo "</td>";

                    echo "<td>";
                        if ($attendance->is_active) {
                            echo "present";
                        } else {
                            echo "absent";
                        }
                    echo "</td>";
                
                    echo "<td>";
                        echo "[". $attendance->created_at . "]";
                    echo "</td>";
                echo "</tr>";
            }

    @endphp
        </tbody>
        <tfoot>
            <tr colspan="3">
                <th>
                    {{-- $get_all_meeting_record->links() --}}
                </th>
            </tr>
        </tfoot>
    </table>
    <script type="text/javascript">
        $(document).ready( function () {
            $('#attendance').DataTable();
        });
    </script>
</body>
</html>
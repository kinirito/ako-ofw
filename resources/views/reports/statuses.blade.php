<!DOCTYPE html>
<html>
<head>
    <title></title>
</head>
<body>
    <h3 align="center">Statuses Report</h3>
    <h5 align="center">{{ ($request->date_from != null ? date('F j, Y', strtotime($request->date_from)) : date('F j, Y')) . ' - ' . ($request->date_to != null ? date('F j, Y', strtotime($request->date_to)) : date('F j, Y')) }}</h5>
    <font size="2">
        <table width="100%" style="border-collapse: collapse; border: 0px;">
            <tr>
                <th style="border: 1px solid; padding: 2px;">Name</th>
                <th style="border: 1px solid; padding: 2px;">Date</th>
                <th style="border: 1px solid; padding: 2px;">Status</th>
                <th style="border: 1px solid; padding: 2px;">Scenario</th>
                <th style="border: 1px solid; padding: 2px;">Agency</th>
                <th style="border: 1px solid; padding: 2px;">Occupation</th>
                <th style="border: 1px solid; padding: 2px;">Address (Abroad)</th>
                <th style="border: 1px solid; padding: 2px;">Country</th>
            </tr>
            <?php $data_loop = 0; $first_page = true; ?>
            @foreach ($statuses as $status)
                @if (($data_loop >= 18 && $first_page) || ($data_loop >= 20 && !$first_page))
                    <?php $data_loop = 0; $first_page = false; ?>
                    </table>
                    <div style="page-break-after: always;"></div>
                    <table width="100%" style="border-collapse: collapse; border: 0px;">
                @endif
                <?php $data_loop++; ?>
                <tr>
                    <td style="border: 1px solid; padding: 2px;">{{ $status->first_name . ' ' . ($status->middle_name != null ? ($status->middle_name . ' ') : '') . $status->last_name }}</td>
                    <td style="border: 1px solid; padding: 2px;"> {{ date('F j, Y', strtotime($status->updated_at)) }} </td>
                    <td style="border: 1px solid; padding: 2px;"> {{ ($status->is_okay ? 'Good Condition' : $status->reason) }} </td>
                    <td style="border: 1px solid; padding: 2px;"> {{ $status->scenario != null ? $status->scenario : '' }} </td>
                    <td style="border: 1px solid; padding: 2px;"> {{ $status->agency }} </td>
                    <td style="border: 1px solid; padding: 2px;"> {{ $status->occupation }} </td>
                    <td style="border: 1px solid; padding: 2px;"> {{ $status->address }} </td>
                    <td style="border: 1px solid; padding: 2px;"> {{ $status->country }} </td>
                </tr>
            @endforeach
        </table>
    </font>
</body>
</html>
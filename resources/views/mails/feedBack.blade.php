<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <meta charset="utf-8">
        <title>Feedback</title>
    </head>
    <body>
        <h4>Feed back Form</h4>
        <table>
            <tr>
                <td>Prenume</td>
                <td>{{ $user['name'] }}</td>
            </tr>
            <tr>
                <td>Nume</td>
                <td>{{ $user['lastName'] }}</td>
            </tr>
            <tr>
                <td>Email</td>
                <td>{{ $user['email'] }}</td>
            </tr>
        </table>
    </body>
</html>

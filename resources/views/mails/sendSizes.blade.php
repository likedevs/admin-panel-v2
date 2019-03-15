<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <meta charset="utf-8">
        <title>Masurari</title>
    </head>
    <body>
        <h4>Masurari</h4>
        <table>
            <tr>
                <td>Produs</td>
                <td>{{ $product->translation($lang->id)->first()->name }}</td>
            </tr>
            <tr>
                <td>Cod produs</td>
                <td>{{ $product->code }}</td>
            </tr>
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
            <tr>
                <td>Telefon</td>
                <td>{{ $user['phone'] }}</td>
            </tr>
            <tr>
                <td>Selectati data intilnirii</td>
                <td>{{ $user['date_from'] }}</td>
            </tr>
            <tr>
                <td>Selectati data casatoriei</td>
                <td>{{ $user['date_to'] }}</td>
            </tr>
            <tr>
                <td>Adresa showroom-ul</td>
                <td>{{ $user['address'] }}</td>
            </tr>
        </table>
    </body>
</html>

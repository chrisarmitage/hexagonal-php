<html>
    <head>
        <title>All customers</title>
    </head>
    <body>
        <table>
            <tr>
                <td>Name</td>
                <td>Category</td>
            </tr>
            @foreach ($customers as $customer)
            <tr>
                <td>{{ $customer->getName() }}</td>
                <td>{{ $customer->getCategory() }}</td>
            </tr>
            @endforeach
        </table>
    </body>
</html>
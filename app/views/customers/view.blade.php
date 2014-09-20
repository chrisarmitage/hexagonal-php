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
            <tr>
                <td>{{ $customer->getName() }}</td>
                <td>{{ $customer->getCategory() }}</td>
            </tr>
        </table>
        <hr />
        <table>
            <tr>
                <td>Document Type</td>
                <td>Document Path</td>
            </tr>
            @foreach ($customerDocuments as $customerDocument)
            <tr>
                <td>{{ $customerDocument->getDocumentType() }}</td>
                <td>{{ $customerDocument->getDocumentPath() }}</td>
            </tr>
            @endforeach
        </table>
    </body>
</html>

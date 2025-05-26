<!DOCTYPE html>
<html>
<head>
    <title>Daftar Produk</title>
</head>
<body>
    <h1>Produk Kami</h1>
    <table border="1" cellpadding="10">
        <tr>
            <th>Nama</th>
            <th>Harga</th>
            <th>Stok</th>
        </tr>
        @foreach ($products as $product)
            <tr>
                <td>{{ $product->nama }}</td>
                <td>{{ $product->harga }}</td>
                <td>{{ $product->stok }}</td>
            </tr>
        @endforeach
    </table>
</body>
</html>
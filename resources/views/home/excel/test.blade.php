

<table>
    <thead>
    <tr>
        <th>Гарчиг</th>
        <th>Агуулга</th>
        <th>Үүсгэсэн</th>
    </tr>
    </thead>
    <tbody>
    @foreach($post as $pt)
        <tr>
            <td>{{ $pt->title }}</td>
            <td>{{ $pt->content }}</td>
            <td>{{ $pt->created_at }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
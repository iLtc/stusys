<extend name="Output:print_default" />
<block name="title">志愿时</block>
<block name="main">

    <table>
        <thead>
            <tr>
                <th>姓名</th>
                <th>学号</th>
                <th>年级</th>
                <th>专业</th>
                <th>总志愿时</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach($results as $result){?>
                <tr>
                    <td><?=$result['info']['name']?></td>
                    <td><?=$result['info']['sid']?></td>
                    <td><?=$result['info']['year']?></td>
                    <td><?=$result['info']['major']?></td>
                    <td><?=$result['sum']?></td>
                </tr>
            <?php }?>
        </tbody>
    </table>
</block>
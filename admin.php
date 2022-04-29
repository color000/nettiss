<?php
error_reporting(E_WARNING);
ini_set("display_errors", 1);
header('Cache-Control:no-cache');
header('Pragma:no-cache');
header('Content-Type: text/html; charset=UTF-8');

$host = 'localhost';
$user = 'lforyou6';
$pw = 'aa0909**';
$dbName = 'lforyou6';


// 현재 페이지 번호 받아오기
if (isset($_GET["page"])) {
    $page = $_GET["page"]; // 하단에서 다른 페이지 클릭하면 해당 페이지 값 가져와서 보여줌
} else {
    $page = 1; // 게시판 처음 들어가면 1페이지로 시작
}

$db_conn = @mysqli_connect($host, $user, $pw, $dbName);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
    <meta name="description" content=""/>
    <meta name="author" content=""/>
    <link rel="shortcut icon" href="./img/favicon.ico">
    <meta property="og:url" content="http://nettiss.com/">
    <meta property="og:title" content="넷티스">
    <meta property="og:type" content="website">
    <meta property="og:image" content="http://nettiss.com/favicon.ico">
    <meta property="og:description" content="넷티스 | NETTISS">
    <title>Nettiss</title>
</head>
<body class="sb-nav-fixed">

<main>
    <div class="container-fluid px-4">
        <div class="table_wrap">
            <table id="mytable">
                <colgroup>
                    <col>
                    <col>
                    <col>
                    <col>
                    <col>
                    <col>
                    <col>
                    <col>
                    <col>
                </colgroup>
                <thead>
                <tr>
                    <th>회사 및 성함</th>
                    <th>이메일</th>
                    <th>번호</th>
                    <th>내용</th>
                    <!--                    <th>삭제</th>-->
                </tr>
                </thead>
                <tbody>
                <?php
                $sql = "select * from contact";
                $result = mysqli_query($db_conn, $sql);

                $total_record = mysqli_num_rows($result); // 불러올 게시물 총 개수

                $list = 5; // 한 페이지에 보여줄 게시물 개수
                $block_cnt = 5; // 하단에 표시할 블록 당 페이지 개수
                $block_num = ceil($page / $block_cnt); // 현재 페이지 블록
                $block_start = (($block_num - 1) * $block_cnt) + 1; // 블록의 시작 번호
                $block_end = $block_start + $block_cnt - 1; // 블록의 마지막 번호

                $total_page = ceil($total_record / $list); // 페이징한 페이지 수
                if ($block_end > $total_page) {
                    $block_end = $total_page; // 블록 마지막 번호가 총 페이지 수보다 크면 마지막 페이지 번호를 총 페이지 수로 지정함
                }
                $total_block = ceil($total_page / $block_cnt); // 블록의 총 개수
                $page_start = ($page - 1) * $list; // 페이지의 시작 (SQL문에서 LIMIT 조건 걸 때 사용)

                // 게시물 목록 가져오기
                $ql2 = "SELECT * FROM contact ORDER BY id DESC LIMIT " . $page_start . ", " . $list;
                $result2 = mysqli_query($db_conn, $ql2);

                // $page_start를 시작으로 $list의 수만큼 보여주도록 가져옴

                while ($board = $result2->fetch_array()) {
                    ?>
                    <tr>
                        <td><?= $board['name'] ?></td>
                        <td><?= $board['email'] ?></td>
                        <td><?= $board['tel'] ?></td>
                        <td><?= $board['contents'] ?></td>
                        <!--                        <td>-->
                        <!--                            <button class="delRow" data-number="-->
                        <?//= $board['id'] ?><!--">삭제</button>-->
                        <!--                        </td>-->
                    </tr>
                    <?php
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="pagination">
        <?php
        if ($page >= 1) {
            echo '<a href="admin.php??page=1" class="left"><</a>';
        }
        ?>
        <ul>
            <?php
            for ($i = $block_start; $i <= $block_end; $i++) {
                if ($page == $i) {
                    echo "<li class='on'><a disabled>$i</a></li>";
                } else {
                    echo "<li><a href='admin.php?page=$i'>$i</a></li>";
                }
            }
            ?>
        </ul>
        <?php
        if ($page >= $total_page) {
            echo "<a class='right' href='admin.php?page=$total_page'>></a>";
        } else {
            echo "<a class='right' href='admin.php?page=$total_page'>></a>";
        }
        ?>
    </div>
</main>


<script>
    $(document).ready(function () {
        $(".delRow").each(function (index) {
            $(this).click(function (e) {
                e.preventDefault();
                if (confirm('해당 데이터를 삭제 하겠습니까?')) {
                    //alert($(this).data('number'));
                    $.post('contact_us_proc.php', {
                        contact_id: $(this).data('number'),
                        q_action: "delete"
                    }, function () {
                        alert('해당 데이터가 삭제 되었습니다.');
                        document.location.href = 'admin.php';
                    });
                }
            })
        });
    });
</script>

</body>
</html>

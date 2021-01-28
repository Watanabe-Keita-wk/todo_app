<?php

function sanitize($before){
    foreach($before as $key=>$val){
        $after[$key]=htmlspecialchars($val,ENT_QUOTES,'UTF-8');
    }
    return($after);
}

function post_check($title,$content){
    if($title==''){
        print '<h3 style="color: #e26a6a;text-align: center;">タイトルを入力してください。</h3>';
    }
    if(mb_strlen($title,'UTF-8') > 30){
        print '<h3 style="color: #e26a6a;text-align: center;">タイトルは30文字以内におさめてください</h3>';
    }

    if($content==''){
        print '<h3 style="color: #e26a6a;text-align: center;">内容を入力してください。</h3>';
    }
}

function display_table($title,$content,$created_at = null,$updated_at = null){
    if(isset($created_at)==true){
        $th_time='作成日時';
        $time=$created_at;
    }else{
        $th_time='最終編集日時';
        $time=$updated_at;
    }

    $text=
    "<table>
        <colgroup span='4'></colgroup>
        <tr>
            <th>タイトル</th>
            <th>内容</th>
            <th>$th_time</th>
        </tr>
        <tr>
            <td>$title</td>
            <td>$content</td>
            <td>$time</td>
        </tr>
    </table>";

    print $text;
}

?>
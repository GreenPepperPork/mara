<style>
.debug {
    background-color: #eee;
    border: 1px solid #000;
    margin: 5px;
    overflow: scroll;
    padding: 5px;
    text-align: left;
}
</style>

<div class="debug">
    <div id="zaor-debug" style="display: block;">
        <table cellspacing="0" cellpadding="5" border="1">
            <caption>PROGRAM ERROR</caption>
            <tbody>
                <tr>
                    <th>NAME</th>
                    <th>MEMORY (byte)</th>
                    <th>MESSAGE</th>
                    <!--<th>TRACE</th>-->
                </tr>
                <?php $warnInfos = $infos['warn']?>
                <?php if (!empty($warnInfos)):?>
                    <?php foreach($warnInfos as $info):?>
                    <?php var_dump($info['info']);exit;?>
                    <tr>
                        <td><?php echo $info['point']?></td>
                        <td><?php echo $info['memory']?></td>
                        <td>
                            &nbsp;
                            line :    <?php echo $info['info']->getLine()?>
                            &nbsp;
                            message : <?php echo $info['info']->getMessage()?>
                        </td>
                        <!-- <td align="right"><?php echo $info['info']->getTraceAsString()?></td>-->
                    </tr>
                    <?php endforeach?>
                <?php endif?>
            </tbody>
        </table>
    </div>
</div>
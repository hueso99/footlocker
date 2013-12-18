<h1>{$RES_0}</h1>
<h2>{$RES_1_0} : {$RES_1_1}</h2>
<table  cellspacing='1' cellpadding='3' border='1' style='width:600px;background-color: rgb(240, 240, 240);border: 1px solid rgb(187, 187, 187);border-collapse: collapse; '>
<th style='background: rgb(80,80,80); color: rgb(232,232,232);'>AV</th>
<th style='background: rgb(80,80,80); color: rgb(232,232,232);'>Signatures</th>
<th style='background: rgb(80,80,80); color: rgb(232,232,232);'>Folder/File</th>
<th style='background: rgb(80,80,80); color: rgb(232,232,232);'>Result</th>

{foreach from=$CONT_ARR item=REC}
<tr {$REC.STYLE}><td align='left'>{$REC.AV}</td><td align='left'>{$REC.SIG}</td><td align='left'>{$REC.FILE}</td><td align='left'>{$REC.RESULT}</td></tr>
{/foreach}

<tr><td align='center' colspan='4' style='font-size:14px;background-color:rgb(40, 40, 40);color:white;'><b><font {$STYLE}>{$FUCK}</font>/{$I}</b></td></tr>
</table>
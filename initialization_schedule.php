<style>

	.cell {
		width: 100px;
		height: 100px;
		border: 1px solid gray;
		border-collapse: collapse;
	}

	.selected {
		background-color: pink;
	}

	.table {
		border: 1px solid gray;
	}

</style>

<?php

	$x = 10;
	$y += 10;
	print $y;

?>

<table width="800" class="table">
	<tr>
		<td class="selected">Matchup #1</td>
		<td class="selected">
			<ul>
			<li>School A</li>
			<li>School B</li>
			<li>School C</li>
			</ul>
		</td>
	</tr>
	<tr>
		<td>Matchup #2</td>
		<td>
			<ul>
			<li>School D</li>
			<li>School E</li>
			<li>School F</li>
			</ul>
		</td>
	</tr>
	<tr>
		<td>Matchup #3</td>
		<td>
			ETC...
		</td>
	</tr>
</table>

<hr />
Select a matchup: 
<select>
<option>1</option>
<option>2</option>
<option>3</option>
<option>4</option>
<option>5</option>
<option>6</option>
<option>7</option>
</select>
Select a Date:
<select>
<option>1</option>
<option>2</option>
<option>3</option>
<option>4</option>
<option>5</option>
<option>6</option>
<option>7</option>
</select>
<input type="submit" value="Enter" />
<hr />
<table>
<tr>
	<td colspan="7" style="text-align: center;"><input type="submit" value="<<"/><h1 style="display: inline;">February</h1><input type="submit" value=">>"/></td>
</tr>
<tr>
<th>SUN</th>
<th>MON</th>
<th>TUE</th>
<th>WED</th>
<th>THU</th>
<th>FRI</th>
<th>SAT</th>
</tr>
<tr>
<td class="cell">1</td>
<td class="cell">2</td>
<td class="cell">3</td>
<td class="cell">4</td>
<td class="cell">5</td>
<td class="cell">6</td>
<td class="cell">7</td>
</tr>
<tr>
<td class="cell">1</td>
<td class="cell">
School A, School B, School C<br />
<small>[<a href="sethomeschool.html">Set home school</a>]</small>
<small>[<a href="#">Delete</a>]</small>
</td>
<td class="cell">3</td>
<td class="cell">4</td>
<td class="cell">5</td>
<td class="cell">6</td>
<td class="cell">7</td>
</tr>
<tr>
<td class="cell">1</td>
<td class="cell">2</td>
<td class="cell">3</td>
<td class="cell">
School D, <u>School E</u> @ School F<br />
<small>[<a href="sethomeschool.html">Set home school</a>]</small>
<small>[<a href="#">Delete</a>]</small>
</td>
<td class="cell">5</td>
<td class="cell">6</td>
<td class="cell">7</td>
</tr>
<tr>
<td class="cell">1</td>
<td class="cell">2</td>
<td class="cell">3</td>
<td class="cell">4</td>
<td class="cell">5</td>
<td class="cell">6</td>
<td class="cell">7</td>
</tr>

</table>
<input type="button" value="Save" onClick="parent.location='menu.html'" />
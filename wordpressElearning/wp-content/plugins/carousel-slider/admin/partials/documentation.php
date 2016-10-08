<div class="wrap">

<div class="notice"> 
	<p><strong>If you like this plugin or if you make money using this or if you want to help me to continue my contribution on open source projects, consider to make a small donation.</strong></p>
	<p><a href="http://sayfulit.com/donate" target="_blank"><img alt="" src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif"></a></p>
	<p><strong>You can also buy premium version from <a href="http://wpeden.com/product/sp-image-carousel/">here</a> or <a href="http://demo.sayfulit.com/sp-image-carousel/">try demo first</a></strong></p>
</div>

<h2>From Version 1.5.0</h2>

<hr><iframe width="560" height="315" src="https://www.youtube.com/embed/O4-EM32h7b4?list=PL9GiQPpTzMv5ftsvX55JO_lTDcKrwCPVn" frameborder="0" allowfullscreen></iframe><hr>

<h2>Usage - linking image</h2>
<p>Without using custom post (Carousels admin menu), you can use custom shortcode to link image and generate carousel slider.</p>
<p>To gererate carousel slider using shortcode, at first write wrapper shortcode as following:</p>
<pre><code>[carousel][/carousel]</code></pre>
<p>Now write the following shortcode inside the wrapper shortcode as many image as you want.</p>
<pre><code>[item img_link=""]</code></pre>
<p>You can add following attribute if you want to link image to custom post, page, image, etc. Like as following</p>
<pre><code>[item img_link="IMAGE_URL_GOES_HERE" href="CUSTOM_URL_GOES_HERE"]</code></pre>
<P>The whole shortcode look likes as following: (See example shortcode.)</P>
<pre style="overflow: auto;"><code>[carousel][item img_link="IMAGE_URL_GOES_HERE"][item img_link="IMAGE_URL_GOES_HERE" href="CUSTOM_URL_GOES_HERE"][item img_link="IMAGE_URL_GOES_HERE"][/carousel]</code></pre>
<h2>Shortcode Attributes</h2>
<p>You can use shortcode attributes to change default functionality. These attributes need to place inside wrapper shortcode. The available shortcode attributes are as following:</p>
<table class="form-table doc-table">
	<tr>
		<th scope="row">Attribute</th>
		<th>Default Value</th>
		<th>Usage</th>
	</tr>
	<tr>
		<th scope="row">id=''</th>
		<td>Random Number.</td>
		<td>Add id if you want to use multiple carousel at same page. If you leave it blank, it will generate random number.</td>
	</tr>
	<tr>
		<th scope="row">items=''</th>
		<td>4</td>
		<td>To set the maximum amount of items displayed at a time with the widest browser width (window >= 1200)</td>
	</tr>
	<tr>
		<th scope="row">items_desktop=''</th>
		<td>4</td>
		<td>This allows you to preset the number of slides visible with (window >= 980) browser width.</td>
	</tr>
	<tr>
		<th scope="row">items_desktop_small=''</th>
		<td>3</td>
		<td>This allows you to preset the number of slides visible with (window >= 768) browser width.</td>
	</tr>
	<tr>
		<th scope="row">items_tablet=''</th>
		<td>2</td>
		<td>This allows you to preset the number of slides visible with (window >= 600) browser width.</td>
	</tr>
	<tr>
		<th scope="row">items_mobile=''</th>
		<td>1</td>
		<td>This allows you to preset the number of slides visible with (window >= 320) browser width.</td>
	</tr>
	<tr>
		<th scope="row">auto_play=''</th>
		<td>true</td>
		<td>Write true to enable autoplay else write false.</td>
	</tr>
	<tr>
		<th scope="row">stop_on_hover=''</th>
		<td>true</td>
		<td>Write true pause autoplay on mouse hover else write false.</td>
	</tr>
	<tr>
		<th scope="row">navigation=''</th>
		<td>true</td>
		<td>Write false to hide "next" and "previous" buttons.</td>
	</tr>
	<tr>
		<th scope="row">nav_color=''</th>
		<td>#d6d6d6</td>
		<td>Enter hex value of color for carousel navigation.</td>
	</tr>
	<tr>
		<th scope="row">nav_active_color=''</th>
		<td>#4dc7a0</td>
		<td>Enter hex value of color for carousel navigation on mouse hover.</td>
	</tr>
	<tr>
		<th scope="row">margin_right=''</th>
		<td>10</td>
		<td>margin-right(px) on item. Default value is 10. Example: 20</td>
	</tr>
	<tr>
		<th scope="row">inifnity_loop=''</th>
		<td>true</td>
		<td>Write true to show inifnity loop. Duplicate last and first items to get loop illusion</td>
	</tr>
	<tr>
		<th scope="row">autoplay_timeout=''</th>
		<td>5000</td>
		<td>Autoplay interval timeout in millisecond. Default: 5000</td>
	</tr>
	<tr>
		<th scope="row">autoplay_speed=''</th>
		<td>500</td>
		<td>Autoplay speen in millisecond. Default: 500</td>
	</tr>
	<tr>
		<th scope="row">slide_by=''</th>
		<td>1</td>
		<td>Navigation slide by x number. Default value is 1.</td>
	</tr>
</table>

<h2>Example 1</h2>
<pre style="overflow: auto;"><code>[carousel][item img_link='http://lorempixel.com/400/200/city/1/'][item img_link='http://lorempixel.com/400/200/city/2/'][item img_link='http://lorempixel.com/400/200/city/3/'][item img_link='http://lorempixel.com/400/200/city/4/'][item img_link='http://lorempixel.com/400/200/city/5/'][item img_link='http://lorempixel.com/400/200/city/6/'][item img_link='http://lorempixel.com/400/200/city/7/'][item img_link='http://lorempixel.com/400/200/city/8/'][item img_link='http://lorempixel.com/400/200/city/9/'][item img_link='http://lorempixel.com/400/200/city/10/'][/carousel]</code></pre>

<h2>Example 2 with attribute</h2>
<pre style="overflow: auto;"><code>[carousel id='myCustomId' items='3' items_desktop='3' margin_right='5' navigation='false'][item img_link='http://lorempixel.com/400/200/city/1/'][item img_link='http://lorempixel.com/400/200/city/2/'][item img_link='http://lorempixel.com/400/200/city/3/'][item img_link='http://lorempixel.com/400/200/city/4/'][item img_link='http://lorempixel.com/400/200/city/5/'][item img_link='http://lorempixel.com/400/200/city/6/'][item img_link='http://lorempixel.com/400/200/city/7/'][item img_link='http://lorempixel.com/400/200/city/8/'][item img_link='http://lorempixel.com/400/200/city/9/'][item img_link='http://lorempixel.com/400/200/city/10/'][/carousel]</code></pre>
</div>
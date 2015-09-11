<?php 
session_start();
include('config.php');
if(isset($_SESSION['user']))
{
$id=$_POST['buttonId4'];
$user=$_SESSION['user'];
$time=localtime(time(),true);
$hh=$time[tm_hour];
$mm=$time[tm_min];
$ss=$time[tm_min];
$time1 = $hh .":".$mm.":".$ss;
$yr=$time[tm_year]+1900;
$mnth=$time[tm_mon]+1;
$day= $time[tm_mday];
$date=$yr."-".$mnth."-".$day;
$sql="INSERT INTO views VALUES ('$user','$id','$date','$time1')";
$result = pg_query($con, $sql) or die("Cannot execute query: $sql\n");
//die();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" 
           xml:lang="en" lang="en">
    <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Search Snippet</title>
    <script src="http://www.google.com/jsapi"></script>

    <script type="text/javascript">

        function searchClicked()
        {
            //document.getElementById("videoResultsDiv").innerHTML = 
              //                      'Loading YouTube videos ...';

            //create a JavaScript element that returns our JSON data.
            var script = document.createElement('script');
            script.setAttribute('id', 'jsonScript');
            script.setAttribute('type', 'text/javascript');
            script.setAttribute('src', 'http://gdata.youtube.com/feeds/' + 
                   'videos?vq=<?php $tmp=urlencode($_POST['buttonId']); echo "$tmp";?>&max-results=1&' + 
                   'alt=json-in-script&callback=showMyVideos&' + 
                   'orderby=relevance&sortorder=descending');

            //attach script to current page -  this will submit asynchronous
            //search request, and when the results come back callback 
            //function showMyVideos(data) is called and the results passed to it
            document.documentElement.firstChild.appendChild(script);
        }

        function showMyVideos(data)
        {
            var feed = data.feed;
            var entries = feed.entry || [];
			//alert(entries);
            var html = ['<div>'];
            for (var i = 0; i < entries.length; i++)
            {
                var entry = entries[i];
                var playCount = entry.yt$statistics.viewCount.valueOf() + ' views';
                var title = entry.title.$t;
				var id = entry.id.$t;
				var id1=id[38];
				var k=id.length;
				//str="Please visit Microsoft!"
			    for (var j = 39; j < k; j++)
				{ 
					id1=id1+id[j];
					}
				//alert(id1);
				var frame='<iframe width="420" height="345" align="middle" src="http://www.youtube.com/embed/'+id1+'?autoplay=1&fs=1" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen> </iframe>';
				//alert(frame);
               html.push(frame);
            }
            html.push('</div>');
            document.getElementById('videoResultsDiv').innerHTML = html.join('');
        }
        searchClicked();
    </script>
    </head>

    <body id="page" onload="searchClicked()">
        <div>
            <p >
                
            </p>
            <div id="videoResultsDiv"></div> 
            <!-- ShowMyVideos() will populate this div with results-->
        </div>
		<!--<iframe width="420" height="345"
src="http://www.youtube.com/embed/XGSy3_Czz8k">
</iframe>-->

    </body>
</html>
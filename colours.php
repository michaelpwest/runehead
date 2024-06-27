<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.1//EN'
'http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd'>
<html xmlns='http://www.w3.org/1999/xhtml' xml:lang='en'>
  <head>
    <title>The RuneHead Hiscores Catalogue Colour Table - By Jemima Pereira</title>
  </head>
  <body onLoad="deMoronize('<? echo $_REQUEST["id"]; ?>');" style="background-color: #FFFFFF; font-family: verdana; font-size: 12px;">
    <!-- 4096 Color Wheel Version 2.1  by Jemima Pereira -->
    <!-- http://jemimap.ficml.org/style/color/wheel.html -->

    <!-- 2.1:  Improved unsafe to smart conversion,         -->
    <!--       added keyboard navigation             (4/04) --> 
    <!-- 2.0:  Converted to HSV to get the greys     (4/04) -->
    <!-- 1.4:  Added optional 3-color list           (2/04) -->
    <!-- 1.31: Added navigation, translation         (2/04) -->
    <!-- 1.3:  Switched to png, reversed direction   (7/03) -->
    <!-- 1.2:  Added picks list, cleaned up style    (7/03) -->
    <!-- 1.1:  Added Web-safe colors                 (7/03) -->
    <!-- 1.0:  Added Mozilla compatibility                  -->
    <!--       Restricted output to the 4096 colors  (7/03) -->
    <script type="text/javascript" src="colours.js"></script>
    <div id="wheel" style="width: 254px; margin-bottom: 5px;">
      <img src="images/hsvwheel.png" style="border: 0px; cursor: pointer;" alt="" onclick="colourchosen('<? echo $_REQUEST["id"]; ?>');" />
    </div>    
    <div id="hexcolour" style="width: 254px; height: 15px; text-align: center;">
      <div id="hexcode" style="background-color: #FFFFFF; width: 80px; height: 15px; margin: 0px auto 0px auto;"></div>
    </div>
  </body>
</html>
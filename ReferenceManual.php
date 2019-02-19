<!DOCTYPE html>	
<html>

    <head>
        <title>New Item Setup Reference Manual</title>
        <?php
        include_once '../connections/conn_slotting.php';
        include_once 'sessioninclude.php';
        include_once 'headerincludes.php';
        include_once 'horizontalnav.php';
        include_once 'verticalnav.php';
        ?>
        <script src="../jquery.js" type="text/javascript"></script>
        <script type="text/javascript" src="../hashchange.js"></script>
        <script type="text/javascript" src="../tabscript.js"></script>
        <script type="text/javascript" src="../fancybox.js"></script>
        <link href="../tabstyles.css" rel="stylesheet" />
        <link href="../csvtable.css" rel="stylesheet" />
        <link href="../fancybox.css" rel="stylesheet" />
        <link rel="shortcut icon" type="image/ico" href="../favicon.ico" />        

        <script>
            $(document).ready(function () {
                $("a#link").fancybox({
                });
            });
            
                $("#reports").addClass('active');
        </script>

    </head>

    <body style="background-color: #FFFFFF;" >

        <!--Main Content-->
        <section id="content"> 
            <section class="main padder" style="margin-top: 75px;padding-left: 100px; "> 



        <div class="wrapper">
            <div id="TableHeading">New Item Reference Manual</div>
            <div id="v-nav">
                <ul>
                    <li tab="dynamic" class="first current">Dynamic Slotting</li>
                    <li tab="measuring">Measuring Tips / Rules</li>
                    <li tab="nesting">Nesting</li>
                    <li tab="accuracy">Measuring Accuracy</li>
                    <li tab="tab5">Other Info 1</li>
                    <li tab="tab6">Other Info 2</li>
                    <li tab="tab7" class="last">Other Info 3</li>

                </ul>

                <div class="tab-content">
                    <h2>
                        Dynamic Slotting Settings
                    </h2>
                    <div class="line-separator"></div>
                    <div class = "tabtext">
                        <ul>
                            <li><strong>OK in Tote Setting</strong></li>
                            <ul>
                                <li>At this point, <strong>EVERY</strong> loose pick item should be setup as OK in T to "Y".  Valid examples to restrict items from going to a tote will be added here as needed.</li>
                                <li>By setting the OK in T field to "N", dynamic slotting will never suggest for the item to go to a tote.</li>
                                <li>If the item dimensions cause the item to not fit in a tote currently, the correct setting is still "Y" because we may get larger totes in the future that will fit the item.</li>
                            </ul>
                            <br><div class='seconddivider'></div><br>
                            <li><strong>OK in Shelf Setting</strong></li>
                            <ul>
                                <li>At this point, <strong>EVERY</strong> loose pick item should be setup as OK in S to "Y".  Valid examples to restrict items from going to a tote will be added here as needed.</li>
                                <li>By setting the OK in S field to "N", dynamic slotting will never suggest for the item to go to a shelf, even if demand requires a shelf.</li>
                                <li>If the item does not stack easily on a shelf, or is slippery and could slide off the shelf, common practice is to either keep the item in vendor packaging and place on shelf, or use a cardboard or plastic tote to place the item on the shelf.</li>
                                <li>In extreme cases, if an item is consistently damaged by falling off the shelf and it is necessary to restrict the item to a tote, please see supervisor/manager to get proper approval.</li>
                            </ul>
                            <br><div class='seconddivider'></div><br>
                            <li><strong>OK in Flow Setting</strong></li>
                            <ul>
<!--                                <li><strong>MOST</strong> loose pick items should be setup as OK in F to "Y".</li>
                                <li>Using totes, boxes and manufacturer cases, most items will be able to be stored in the flow rack.</li>-->
                                <li>If there is a case package unit populated in the warehouse inquiry screen, please set the OK in Flow setting to "Y".</li>
                                <li>If you are using the <a href="slotrec.php">New Item Slot Recommendation</a> tool, the case package unit will be displayed if available.</li>
                                <li>If the vendor case package unit does not flow properly down the lanes, please check with supervisor/manager to determine if plastic or cardboard totes can be utilized.</li>
                                <li>In extreme cases, if there is a vendor case package setup and the item cannot be placed in the flow, set the OK in Flow setting to "N".</li>
                            </ul>
                            <br><div class='seconddivider'></div><br>
                        </ul>
                    </div>
                </div>

                <div class="tab-content">
                    <h2>Measuring Tips / Rules</h2>
                    <div class="line-separator"></div>
                    <div class = "tabtext">
                        <h3 style= "margin-bottom: 5px; margin-top: 12px;">General Rules</h3>
                        <ul class="enlarge">
                            <li>The length dimension should always be the longest dimension.</li>
                            <li>The exception to the length rule is for liquids that need to sit upright (bottles, gallons, etc.).  For these items, the height of the product should be the vertical distance when item is placed on the shelf.</li>
                        </ul>
                        <br><div class='seconddivider'></div><br>

                        <h3 style= "margin-bottom: 5px; margin-top: 12px;">Items in Bubble Wrap</h3>
                        <ul class="enlarge">
                            <li>Fold the bubble wrap around the item.  Most items allow you to fold at least two times.</li>
                            <li>Measure the item and the bubble wrap to get the most accurate measurement of the volume.</li>
                            <li>Example Item:</li>
                            <ul>
                                <li><a href="pics/bubblewrap01.jpg" id="link"> Item 248-5394</a></li>
                                <li><a href="pics/bubblewrap02.jpg" id="link">Length in CM: 12.0 cm</a></li>
                                <li><a href="pics/bubblewrap02.jpg" id="link">Width in CM: 10.0 cm</a></li>
                                <li><a href="pics/bubblewrap03.jpg" id="link">Height in CM: 5.0 cm</a></li>
                            </ul>
                        </ul>
                        <br><div class='seconddivider'></div><br>

                        <h3 style= "margin-bottom: 5px; margin-top: 12px;">Items in Flimsy Sleeves</h3>
                        <ul>
                            <li>If the sleeve does not add a meaningful amount of volume to the overall item, standard procedure is to fold the sleeve two times around the product.</li>
                            <li>Measure the folded sleeve and product to determine appropriate dimensions.</li>
                            <li>Use common sense for very small items.  Decreasing the size too much could try to overfill the location substantially.</li>
                            <li>If you are uncertain if the dimensions are correct, please refer to the <a href="truefitcalc.php">true fit calculator</a> after you have input the item dimensions to verify accuracy of measurements.</li>
                            <li>Example Item:</li>
                            <ul>
                                <li><a href="pics/sleeve01.jpg" id="link">Item 106-7657</a></li>
                                <li><a href="pics/sleeve02.jpg" id="link">Length in CM: 2.0 cm</a></li>
                                <li><a href="pics/sleeve02.jpg" id="link">Width in CM: 1.0 cm</a></li>
                                <li><a href="pics/sleeve03.jpg" id="link">Height in CM: 0.3 cm</a></li>
                            </ul>
                        </ul>
                        <br><div class='seconddivider'></div><br>

                        <h3 style= "margin-bottom: 5px; margin-top: 12px;">Items that are Oddly shaped</h3>
                        <ul>
                            <li>The length is the longest distance between the two most extreme points on the item. </li>
                            <li>Try to refrain from measuring diagonally.  You should instead measure from the two points as if they were on a horizontal plane</li>
                            <!--                            <li>Example Item:</li>
                                                        <ul>
                            
                                                            <li>Item XXX-XXXX</li>
                                                            <li>Length in CM: XXcm</li>
                                                            <li>Width in CM: XXcm</li>
                                                            <li>Height in CM: XXcm</li>
                                                        </ul>-->
                        </ul>
                        <br><div class='seconddivider'></div><br>
                        <h3 style= "margin-bottom: 5px; margin-top: 12px;">Multiple Items in Bags</h3>
                        <ul>
                            <li>Arrange the items in the bag in a natural position as they would lay in a tote or shelf.</li>
                            <li>This might require you to lightly shake the products in the bag so they are not grouped to one side of the bag.</li>
                            <li>To accurately measure the height, it might be necessary to place the item on a hard surface, place cardboard on top of the product, and measure from the hard surface to the cardboard.</li>
                            <li>If you are uncertain if the dimensions are correct, please refer to the <a href="truefitcalc.php">true fit calculator</a> after you have input the item dimensions to verify accuracy of measurements.</li>
                            <li>Example Item:</li>
                            <ul>
                                <li><a href="pics/multinbag01.jpg" id="link">Item 107-3454</a></li>
                                <li><a href="pics/multinbag02.jpg" id="link">Length in CM: 19.0 cm</a></li>
                                <li><a href="pics/multinbag02.jpg" id="link">Width in CM: 16.5 cm</a></li>
                                <li><a href="pics/multinbag03.jpg" id="link">Height in CM: 3.9 cm</a></li>
                            </ul>
                        </ul>




                    </div>
                </div>

                <div class="tab-content">
                    <h2>Nesting</h2>
                    <div class="line-separator"></div>
                    <div class = "tabtext">
                        <h3 style= "margin-bottom: 5px; margin-top: 12px;">Incremental Side</h3>
                        <ul class="enlarge">
                            <li>Incremental side defines the measure of the side which varies when items are nested.  Valid entries are H (height), W (width), L (length).</li>
                            <li>The correct entry depends on how the item's L, W, and H are setup in the system.</li>
                            <li>To determine the correct entry, nest two units together and make note of which dimension (L,W,H) increases after nesting.</li>
                            <li>Refer to the dimensions in the system to correctly identify which dimension is increasing.</li>
                            <li>Example Item 666-3598:</li>
                            <ul>
                                <li>The incremental side is the <a href="pics/nesting1.jpg" id="link">Length.</a></li>
                                <li>The Height and Width of the product when nested together stays the same, however the overall length of the product has increased.</li>
                            </ul>
                        </ul>
                        <br><div class='seconddivider'></div><br>
                        <h3 style= "margin-bottom: 5px; margin-top: 12px;">Incremental Space</h3>
                        <ul class="enlarge">
                            <li>Incremental Space is the increase in centimeters measure when two items are nested together.  Be sure to place the lid into or on top of the product to get an accurate increase in space.</li>
                            <li>A valid entry is a number between 0 and 9999.9.</li>
                            <li>To determine the correct entry, nest two units together and measure the increase in centimeters of the incremental side from the top of the lid to the top of the lip of the nested item.</li>
                            <li>It is important to ONLY measure the increase of the incremental side, and not the complete dimension.</li>
                            <li>Example Item 666-3598:</li>
                            <ul>
                                <li>The incremental space is <a href="pics/nesting2.jpg" id="link">3.0 cm.</a></li>
                                <li>Be sure to only measure the additional space created when two units are nested together.</li>
                            </ul>
                        </ul>

                        <br><div class='seconddivider'></div><br>
                        <h3 style= "margin-bottom: 5px; margin-top: 12px;">Max Unit</h3>
                        <ul class="enlarge">
                            <li>Max unit defines the maximum logical quantity to be nested a single shipment for this item. Valid values are 0 to 99</li>
                            <li>A valid entry is a number between 0 and 99.</li>
                            <li>To determine the correct entry, calculate the maximum number of units that can be nested together and placed in a #12 box.</li>
                            <li>Please note, this is NOT the total units that can fit in a #12 box.  Max unit refers to the maximum contiguous units that can fit in the box before a new stack of items must be started.</li>
                            <li>Example Item 666-3598:</li>
                            <ul>
                                <li>The max unit is <a href="pics/nesting3.jpg" id="link">6 units.</a></li>
                                <li>This is the max quantity that can fit in a #12 box utilizing only one nesting stack.</li>
                            </ul>
                        </ul>

                    </div>
                </div>


                <div class="tab-content">
                    <h2>
                        Importance of Measuring Accurately to the Nearest 0.1 cm
                    </h2>
                    <div class="line-separator"></div>
                    <div class = "tabtext">
                        <h3>When measuring any item dimension, please measure to the nearest 0.1 cm. <br><br> Do not round any measurement to the nearest centimeter.  Measuring inaccurately affects the following:</h3> 
                        <ul>
                            <li><strong>Slotting</strong></li>
                            <ul>
                                <li>When determining what size to slot an item, a "true fit" is calculated to determine the maximum quantity that can fit in any given size grid5.</li>
                                <li>If all three dimensions (length, width, height) are not accurate, the "true fit" will be incorrect, thus potentially slotting the item to a wrong sized grid5.</li>
                                <li>Below is an example of how a 0.3 cm inaccuracy can affect the size of the correct grid5.</li>
                                <br><img class="tabimage" margin="0px 10px 0px 10px" src="pics/measureaccurately.jpg"/>
                            </ul>
                            <br><div class='seconddivider'></div><br><br>
                            <li><strong>Boxing</strong></li>
                            <ul>
                                <li>When determining what size tote on a production picking cart a customer's order should be placed, the boxing program calculates the smallest tote size the item can be placed based off each of the items' dimensions.</li>
                                <li>The dimensions of the item also determine the smallest sized outbound box the items can be placed.</li>
                                <li>Incorrectly measuring the items can cause either wasted space in outbound boxes, or cause production TSMs to re-box a customer's order into two boxes.</li>
                            </ul>
                            <br><div class='seconddivider'></div><br><br>
                            <li><strong>Measuring incorrectly can also cause concerns for putaway and replenishment by causing "won't fits" or by creating additional moves by not properly filling the location to the max.</strong></li>
                        </ul>
                    </div>
                </div>

                <div class="tab-content">
                    <h2>
                        Additional Info Can be Added Here
                    </h2>
                    <div class="line-separator"></div>
                    <div class = "tabtext">
                        <ul>
                            <li>Need to add info here...</li>
                        </ul>
                    </div>
                </div>

                <div class="tab-content">
                    <h2>
                        Additional Info Can be Added Here
                    </h2>
                    <div class="line-separator"></div>
                    <div class = "tabtext">
                        <ul>
                            <li>Need to add info here...</li>
                        </ul>
                    </div>
                </div>

                <div class="tab-content">
                    <h2>
                        Additional Info Can be Added Here
                    </h2>
                    <div class="line-separator"></div>
                    <div class = "tabtext">
                        <ul>
                            <li>Need to add info here...</li>
                        </ul>
                    </div>
                </div>
            </div>

        </div>




            </section>
            </section>

    </body>
</html>


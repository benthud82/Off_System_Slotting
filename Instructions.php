<!DOCTYPE html>	
<html>

    <head>
        <title>New Item Setup Instructions</title>
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
        <link href="../tabstyles.css" rel="stylesheet" />
        <link href="../csvtable.css" rel="stylesheet" />
        <link rel="shortcut icon" type="image/ico" href="../favicon.ico" />        


    </head>


     <body style="background-color: #FFFFFF;" >
                 <!--Main Content-->
        <section id="content"> 
            <section class="main padder" style="margin-top: 75px;padding-left: 100px; "> 

        <div class="wrapper">
            <div id="TableHeading">New Item Setup Instructions</div>
            <div id="v-nav">
                <ul>
                    <li tab="tab1" class="first current">Step 1 - Verification</li>
                    <li tab="tab2">Step 2 - Characteristics</li>
                    <li tab="tab3">Step 3 - Dynamic Slotting</li>
                    <li tab="tab4">Step 4 - PFR Settings</li>
                    <li tab="tab5">Step 5 - Nesting Settings</li>
                    <li tab="tab6">Step 6 - Slot Size</li>
                    <li tab="tab7" class="last">Step 7 - Assign Location</li>
                </ul>

                <div class="tab-content">
                    <h4>
                        Step 1 - Verification
                    </h4>
                    <div class="line-separator"></div>
                    <div class = "tabtext">
                        <ol type="1">
                            <img class="tabimage" style="float: right" margin="0px 0px 0px 0px" src="pics/whsinq.jpg" width="500" height="350"/>
                            <li>Navigate to "Warehouse Inquiry" screen.</li>
                            <li>Enter item code</li>
                            <li>Verify the following item characteristics to putaway label and "Warehouse Inquiry" screen:</li>
                            <ol type ="a">
                                <li>Quantity</li>
                                <li>Vendor Part#</li>
                                <li>Size</li>
                                <li>Description</li>
                                <li>Strength</li>
                                <li>Expiration Date</li>
                                <li>Temperature Requirements - Enter "L" on location screen to see if the type is "RI" for refrigerated and shipped on ice, "R" for refrigerated not shipped on ice, and "RS" for refrigerated seasonal, and "FZ" for freezer. </li>
                                <li>Hazardous</li>
                                <li>Lot #</li>
                                <li>Temperature Requirements</li>
                                <li>Check Class - RX, Drug, Ref</li>
                                <li class="lastli">Specialty Field - Ref, BO, HAZ</li>
                            </ol>
                            <li>If discrepancy is found, ensure "Standardized Communication" is submitted to correct issue.</li>
                            <li>If discrepancy cannot be corrected with "Standardized Communication", return to control desk.</li>


                        </ol>
                    </div>
                </div>

                <div class="tab-content">
                    <h4>
                        Step 2 - Item Physical Characteristics
                    </h4>
                    <div class="line-separator"></div>
                    <div class = "tabtext">
                        <ol type="1">

                            <li>With item activated in "Warehouse Inquiry" screen, Press F8 to navigate to "Item Physical Characteristics" screen.</li>
                            <li>Verify that settings are at corporate level noted by "Corp Warehouse" in upper left hand corner.  If not at corporate level, press F9 to activate corporate level.</li>
                            <li>Press F5 to access "Update Main Screen."</li>
                            <li>Navigate to line "EA" under the "UM" column.  If "each" package unit is not defined, proceed to "CA" under the "UM" column.</li>
                            <li>If the only each selling unit is a case package, please proceed to "CA" under the "UM" column and do not set up any characteristics under the "EA" column.</li>
                            <strong>Please note: For "NEW" items, please verify characteristics, do not re-enter characteristics unless change is necessary.</strong>
                            <ol type ="a">
                                <li>Enter the selling unit of measure under the "UM" column for the each.</li>
                                <li>Measure the length in centimeters to the nearest tenth (ex: 10.5). <a href="referencemanual.php#measuring">Measuring Tips and General Rules.</a></li>
                                <li>Measure the width in centimeters to the nearest tenth. <a href="referencemanual.php#accuracy">Why is measuring to the nearest tenth important?</a></li></li>
                                <li>Measure the height in centimeters to the nearest tenth.</li>
                                <li>Record the weight of product to the nearest tenth.</li>
                                <li>Pilferageable (PF) - Enter a "N".  Future use, field is not active.</li>
                                <li>Weight Class (WC) - Enter a "4". This field is not active for "each" package unit.</li>
                                <li>Conveyable (CV) - Enter a "Y".  This field is not active for "each" package unit.</li>
                                <li>Totable (TO) - Enter a "Y".  Future use, field is not active.</li>
                                <li>Foldable (FL) - If <strong>ITEM </strong>can be folded, enter "Y", else enter a "N". Future use, field is not active.</li>
                                <li>Liquid (LQ) - Enter appropriate liquid type if product is liquid (ex: "BT", "IV").  Enter "?" for listing of liquid types.</li>
                                <li>Rotatable (RO) - If product cannot be rotated, enter a "N".  Else, enter a "Y".</li>
                                <li>Stackable (STA) - Enter number 1 - 99 if it is necessary to limit the number of layers that can be stacked on top of each other. Else, leave blank.</li>
                                <li>Envelopable (EV) - Enter "Y" if item can be SHIPPED in an envelope, else enter a "N"</li>
                                <li>Serial Number (SN) - Enter the number of serial numbers if item has serial number, else enter "N".  System will update per item master.</li>
                                <li class="lastli">Pedigree Lot (PL) - Enter a "N".  System will update per item master.</li>
                                <img class="tabimage" margin="0px 0px 0px 0px" src="pics/itemchar.jpg" width="600" height="350"/>
                            </ol>

                            <li>If inner pack package unit is received, navigate to line "PK" under the "UM" column.</li>
                            <strong>Please note: For "NEW" items, please verify characteristics, do not re-enter characteristics unless change is necessary.</strong>
                            <ol type ="a">
                                <li>Enter the selling unit of measure under the "UM" column for the each.</li>
                                <li>Measure the length in centimeters to the nearest tenth (ex: 10.5).</li>
                                <li>Measure the width in centimeters to the nearest tenth.</li>
                                <li>Measure the height in centimeters to the nearest tenth.</li>
                                <li>Record the weight of product to the nearest tenth.</li>
                                <li>Pilferageable (PF) - Enter a "N".  Future use, field is not active.</li>
                                <li>Weight Class (WC) - Enter a "4". This field is not active for "PK" package unit.</li>
                                <li>Conveyable (CV) - Enter a "Y".  This field is not active for "PK" package unit.</li>
                                <li>Totable (TO) - Enter a "Y".  Future use, field is not active.</li>
                                <li>Foldable (FL) - Enter a "N".  Future use, field is not active.</li>
                                <li>Rotatable (RO) - If product cannot be rotated, enter a "N".  </li>
                                <li class="lastli">Stackable (STA) - Enter number 1 - 99 if it is necessary to limit the number of layers that can be stacked on top of each other.</li>
                            </ol>

                            <li>If case package unit is received, navigate to line "CA" under the "UM" column.</li>
                            <strong>Please note: For "NEW" items, please verify characteristics, do not re-enter characteristics unless change is necessary.</strong>
                            <ol type ="a">
                                <li>Enter the selling unit of measure under the "UM" column for the each.</li>
                                <li>Measure the length in centimeters to the nearest tenth (ex: 10.5).</li>
                                <li>Measure the width in centimeters to the nearest tenth.</li>
                                <li>Measure the height in centimeters to the nearest tenth.</li>
                                <li>Record the weight of product to the nearest tenth.</li>
                                <li>Pilferageable (PF) - Enter a "N".  Future use, field is not active.</li>
                                <li>Weight Class (WC) - Dallas enter "2".</li>
                                <li>Conveyable (CV) - Enter a "Y" if case can be placed on conveyor.  If case is not conveyable, enter a "N".</li>
                                <li>Totable (TO) - Enter a "Y".  Future use, field is not active.</li>
                                <li>Rotatable (RO) - If product cannot be rotated, enter a "N", else enter a "Y".  </li>
                                <li class="lastli">Stackable (STA) - Enter number 1 - 99 if it is necessary to limit the number of layers that can be stacked on top of each other.</li>
                            </ol>
                            <img class="tabimage" style="float: right" margin="0px 0px 0px 0px" src="pics/pallet.jpg" alt="fill layer photoshop cs5" width="300" height="200"/>                           
                            <li>If pallet package unit is received, navigate to line "PL" under the "UM" column.</li>
                            <strong>Please note: For "NEW" items, please verify characteristics, do not re-enter characteristics unless change is necessary.</strong>
                            <ol type ="a">

                                <li>Enter the selling unit of measure under the "UM" column for the each.</li>
                                <li>Measure the length in centimeters to the nearest tenth (ex: 10.5).  Please refer to the diagram. </li>
                                <li>Measure the width in centimeters to the nearest tenth.  Please refer to the diagram.</li>
                                <li>Measure the height in centimeters to the nearest tenth.  Please refer to the diagram.</li>
                                <li>Record the weight of product to the nearest then tenth.  Multiply case weight by number of cases on pallet and add 30 pounds for average pallet weight.</li>
                                <li class="lastli">Pilferageable (PF) - Enter a "N".  Future use, field is not active.</li>
                            </ol>
                            <li>Disregard "MP" under "UM" column.</li>
                            <li>Press "F7" to accept and update changes.</li>
                        </ol>
                    </div>
                </div>

                <div class="tab-content">
                    <h4>
                        Step 3 - Dynamic Slotting Characteristics
                    </h4>
                    <div class="line-separator"></div>
                    <div class = "tabtext">
                        <ol type="1">
                            <li>Navigate to "Mode" at upper left hand corner of the "Item Physical Characteristics" screen.</li>
                            <li>Enter "DY" to activate the dynamic slotting settings screen.</li>
                            <li>Press F5 to edit settings.</li>
                            <li>Navigate to line "EA" if each package unit was defined in previous step.</li>
                            <strong>Please note: For "NEW" items, please verify characteristics, do not re-enter characteristics unless change is necessary.</strong>
                            <ol type ="a">
                                <li>Stock Days Active (SA) - Enter a "N".  This setting is not active.</li>
                                <li>Stock Days (SD) - Default to blank.  This field is not active.</li>
                                <li>Min Weeks (Mn Wk) - Default to blank.  This field is not active.</li>
                                <li>Dynamic Slot (DS) - Enter a "Y".  Determines if the item will be active for dynamic slotting.</li>
                                <li>Min Case Weeks (Min Cse Wks) - Default to blank.  This field is not active for loose.</li>
                                <li>Case Hold Reserve (Cse Hld Rsv) - Default to blank.  This field is not active for loose.</li>
                                <li>Multi-Parts Item (Mlt Prt I) - Default to blank.  This field is not active for loose.</li>
                                <li>Multi-Parts Labels (Mlt Prt L) - Default to blank.  This field is not active for loose.</li>
                                <li>Orientation on Shelf (Ori on Shf) - Default to blank.  Enter L, W, H at the <strong>LOCAL </strong> level to specify desired orientation if necessary.</li>
                                <li>Flow Rack Orientation (Flo Rck Ori) - Default to blank.  Enter L, W, H at the <strong>LOCAL </strong> level to specify desired orientation if necessary.</li>
                                <li>Date Code (DC) - If item is dated, enter an "E", else leave blank.</li>
                                <li>Needs Case Location (NCL) - Enter a "N".  This field is not active for loose.</li>
                                <li>Needs IP Location (NIP) - Enter a "N".  This field is not active for loose.</li>
                                <li>OK in Tote (OK T) - Enter a "Y". Please see supervisor/manager if "N" is an appropriate setting.  <a href="referencemanual.php#dynamic">When would I enter a "N"?</a></li>
                                <li>OK in Shelf (OK S) - Enter a "Y". Please see supervisor/manager if "N" is an appropriate setting.  <a href="referencemanual.php#dynamic">When would I enter a "N"?</a></li>
                                <li>Bin Reserve (BR) - Enter a "Y".  Please see supervisor/manager if "N" is an appropriate setting. <a href="referencemanual.php#dynamic">  When would I enter a "N"?</a></li>
                                <li>OK in Drawer (OK D) - Enter a "N".  If item can be placed in drawer (Stanley Vidmar) then enter "Y".</li>
                                <li>OK in Flow Rack (OK F) - Enter a "Y" if item can be placed in flow rack. <a href="referencemanual.php">  How do I know?</a></li>
                                <li>Hazardous (HM) - If item is hazardous, enter a "Y".  Else, enter a "N".</li>
                                <li>Requires Refrigeration (Req R) - If item requires refrigeration, enter a "Y".  Else, enter a "N".</li>
                                <li>Requires Drug (Req D) - If item requires drug room, enter a "Y".  Else, enter a "N".</li>
                                <li>Requires Vault (Req V) - If item requires vault, enter a "Y".  Else, enter a "N".</li>
                                <li>Seasonal (SEA) - Enter a "N". This field is not active.</li>
                                <li>Small Case (SC) - Enter a "N". This field is not active.</li>
                                <li class="lastli">Truckable Item (TI) - Enter a "N". This field is not active.</li>
                            </ol>
                            <li>Navigate to line "PK" if each package unit was defined in previous step.</li>
                            <strong>Please note: For "NEW" items, please verify characteristics, do not re-enter characteristics unless change is necessary.</strong>
                            <ol type ="a">
                                <li>Stock Days Active (SA) - Enter a "N".  This field is not active.</li>
                                <li>Stock Days (SD) - Default to blank.  This field is not active.</li>
                                <li>Min Weeks (Mn Wk) - Default to blank.  This field is not active.</li>
                                <li class="lastli">Dynamic Slot (DS) - Enter a "Y".  Determines if the item will be active for dynamic slotting.</li>
                            </ol>
                            <li>Navigate to line "CA" if each package unit was defined in previous step.</li>
                            <strong>Please note: For "NEW" items, please verify characteristics, do not re-enter characteristics unless change is necessary.</strong>
                            <ol type ="a">
                                <li>Stock Days Active (SA) - Enter a "Y".  This setting is not active.</li>
                                <li>Stock Days (SD) - Default to blank.  This field is not active.</li>
                                <li>Dynamic Slot (DS) - Enter a "Y".  Dynamic slotting is not active for case.</li>
                                <li>Min Case Weeks (Min Cse Wks) - Default to blank.  Enter value between 0-999 to specify minimum number of stocking weeks to hold in case location.</li>
                                <li class="lastli">Case Hold Reserve (Cse Hld Rsv) - Default to blank.  Enter value between 0-999 to specify number of cases to hold in reserve.</li>
                            </ol>
                            <li>Navigate to line "PL" if each package unit was defined in previous step and enter "N" for the "DS" field.</li>
                            <li>Press "F7" to accept and update changes.</li>
                        </ol>
                    </div>
                </div>


                <div class="tab-content">
                    <h4>
                        Step 4 - Pick From Reserve Settings
                    </h4>
                    <div class="line-separator"></div>
                    <div class = "tabtext">
                        <ol type="1">
                            <li>If you received a case package unit, navigate to "Mode" at upper left hand corner of the "Item Physical Characteristics" screen.</li>
                            <li>Verify that settings are at corporate level noted by "Corp Warehouse" in upper left hand corner.  If not, press F9 to activate Corporate level.</li>
                            <li>Enter "PR" to activate the pick from reserve settings screen.</li>
                            <li>Press F5 to edit settings.</li>
                            <li>If case package unit can be picked from a reserve location, enter "P" under the "Cor Pfr Act" column and enter case package unit quantity under the "Pfr Pkg Unit" column.</li>
                            <li>If case package unit cannot be picked from reserve location, enter "Z" under the "Cor Pfr Act" column and leave "Pfr Pkg Unit" column blank.</li>
                            <li>Leave Promo Start and End Dates blank.</li>
                            <li>Press F7 to accept and update changes.</li>
                            <li>Press F9 to switch to DC level.</li>
                            <li>Enter "PR" in the mode field to activate the pick from reserve settings screen.</li>
                            <li>Press F5 to edit settings.</li>
                            <li>If case package unit can be picked from a reserve location in your local DC, enter "Y" under the "Pfr Act" column.  "Pfr Pkg Unit" defaults from the corporate screen.</li>
                            <li>If case package unit cannot be picked from reserve location in your local DC, enter "N" under the "Pfr Act" column.  "Pfr Pkg Unit" defaults from the corporate screen.</li>
                            <li>Leave Promo Start and End Dates blank.</li>
                            <li>Press F7 to accept and update changes.</li>
                            <img class="tabimage" margin="0px 0px 0px 0px" src="pics/pfrchar1.jpg" width="400" height="300"/>
                            <img class="tabimage" margin="0px 0px 0px 0px" style="float: right" src="pics/pfrchar2.jpg" width="400" height="300"/>
                        </ol>
                    </div>
                </div>

                <div class="tab-content">
                    <h4>
                        Step 5 - Nesting Settings
                    </h4>
                    <div class="line-separator"></div>
                    <div class = "tabtext">
                        <ol type="1">
                            <li>If item is nestable, enter "NS" in the mode field</li>
                            <li>Incremental Side - Defines the measure of the side which varies when items are nested.  Enter H,W, or L.  <a href="referencemanual.php#nesting">  I need help.</a></li>
                            <li>Incremental Space - The increase in volume measure when two of these items are nested.  Valid values are 0 to 9999.9.  <a href="referencemanual.php#nesting">  I need help.</a></li></li>
                            <li>Max Unit - Defines the maximum logical quantity to be nested a single shipment for this item. Valid values are 0 to 99.  <a href="referencemanual.php#nesting">  I need help.</a></li></li>
                            <li>Volume Incrse - This is a system calculated field.</li>
                            <li>Volume Open - This is a system calculated field.</li>
                            <li>Press F7 to accept and update changes.</li>
                        </ol>
                    </div>
                </div>

                <div class="tab-content">
                    <h4>
                        Step 6 - Determine Optimal Slot Size
                    </h4>
                    <div class="line-separator"></div>
                    <div class = "tabtext">
                        <ol type="1">
                            <li>Use the slot recommendation tool located here: <a href="slotrec.php">Slotting Recommendation</a></li>
                            <li>You can also use the mass location assignment tool located here: <a href="newitemlocrec.php">Mass Location Assignment</a></li>
                            <li>If it is necessary to place this item in a specific sized grid, use the true fit calculator tool located here: <a href="truefitcalc.php">True Fit Calculator</a></li>
                        </ol>
                    </div>
                </div>

                <div class="tab-content">
                    <h4>
                        Step 7 - Assigning Primary Location(s)
                    </h4>
                    <div class="line-separator"></div>
                    <div class = "tabtext">
                        <ol type="1">
                            <li>Press "F3" to exit to Warehouse Inquiry Screen.</li>
                            <strong>Please note: If the slot recommendation tools are used, please skip to step 8.</strong>
                            <li>Navigate to "LOCATION" field.</li>
                            <li>Enter corresponding location code (W, A, B, D, E, C, I etc.), tab to next open field and enter "P" for open primaries.</li>
                            <li>Navigate to "GRID(Open Primaries)/Size(Open Reserves)" field and enter size of corresponding location grid (T004, S047).</li>
                            <li>Record selected location on New Item Assignment Register.</li>
                            <li>"F3" to exit.</li>
                            <li>"F3" to exit.</li>
                            <li>In the Inventory Control Menu, select Location Master Maintenance option.</li>
                            <li>Function (A/C/D): "A".</li>
                            <li>Prim/Resv (P/R) : "P".</li>
                            <li>Location: Enter selected location from step 5 or from the slot recommendation tools.</li>
                            <li>Item Code: Enter Item code.</li>
                            <li>Press "Enter".</li>
                            <li>Location Code: Enter "A" for lowest selling package unit.  Enter "B" if item is sold as each and case.</li>
                            <li>Lot Number:  Bypass.</li>
                            <li>Package Unit: Enter selling unit.  For "A" enter 1, for "B" enter case package unit.</li>
                            <li>Capacity (MAX):  Enter maximum quantity that will fit in location or use the recommended max from the slot recommendation tools.</li>
                            <li>Restock Pt (MIN): Enter desired minimum quantity for restock point.  Example: 25% of Capacity (MAX) quantity.</li>
                            <li>Slot Size: Auto populated.</li>
                            <li>Press F5 to accept and update.</li>
                        </ol>
                    </div>
                </div>

            </div>
        </div>
            </section>
            </section>
            
                 <script>
                     $("#reports").addClass('active');
                 </script>
    </body>
</html>


SELECT 
    histitem_whse,
    histitem_item,
    histitem_location,
    CUR_LOCATION,
    AVG_DAILY_PICK,
    CAST(SUBSTRING(histitem_location, 4, 2) AS UNSIGNED) AS OLD_BAY,
    CAST(SUBSTRING(CUR_LOCATION, 4, 2) AS UNSIGNED) AS NEW_BAY,
    AVG_DAILY_PICK * (SELECT 
            FEET
        FROM
            slotting.bay_walkfeet
        WHERE
            BAY = CAST(SUBSTRING(histitem_location, 4, 2) AS UNSIGNED)) AS OLD_WALKFEET,
    AVG_DAILY_PICK * (SELECT 
            FEET
        FROM
            slotting.bay_walkfeet
        WHERE
            BAY = CAST(SUBSTRING(CUR_LOCATION, 4, 2) AS UNSIGNED)) AS NEW_WALKFEET
FROM
    slotting.slottingscore_hist_item
        JOIN
    slotting.itemsmoved_2018goal ON histitem_whse = goal_whse
        AND goal_item = histitem_item
        AND histitem_pkgu = goal_pkgu
        JOIN
    slotting.my_npfmvc ON WAREHOUSE = goal_whse
        AND ITEM_NUMBER = goal_item
        AND PACKAGE_UNIT = goal_pkgu
WHERE
    histitem_date = (goal_movedate)
  
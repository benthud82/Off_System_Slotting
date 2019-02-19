SELECT 
    goal_item,
    MVTYPE,
    SUM(CASE
        WHEN MVDATE < goal_movedate THEN 1
        ELSE 0
    END) AS MOVES_BEFORE,
    SUM(CASE
        WHEN MVDATE < goal_movedate THEN 1
        ELSE 0
    END) / DATEDIFF(goal_movedate, '2018-01-01') AS BEF_MOVES_PER_DAY,
    SUM(CASE
        WHEN MVDATE >= goal_movedate THEN 1
        ELSE 0
    END) AS MOVES_AFTER,
    SUM(CASE
        WHEN MVDATE >= goal_movedate THEN 1
        ELSE 0
    END) / DATEDIFF(CURDATE(), goal_movedate) AS AFT_MOVES_PER_DAY,
    DATEDIFF(goal_movedate, '2018-01-01') AS DAYS_TO_MOVE,
    DATEDIFF(CURDATE(), goal_movedate) AS MOVE_TO_TODAY
FROM
    slotting.itemsmoved_2018goal
        JOIN
    slotting.7moves ON goal_item = MVITEM
        AND MVTPKG = goal_pkgu
WHERE
    goal_whse = 7 AND MVDATE >= '2018-01-01'
        AND DATEDIFF(CURDATE(), goal_movedate) > 10 and MVTYPE not in ('CM','DS','SM')
GROUP BY goal_item , MVTYPE
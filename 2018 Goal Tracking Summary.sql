SELECT 
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
    END) / DATEDIFF(CURDATE(), goal_movedate) AS AFT_MOVES_PER_DAY
FROM
    slotting.itemsmoved_2018goal
        JOIN
    slotting.9moves ON goal_item = MVITEM
        AND MVTPKG = goal_pkgu
WHERE
    goal_whse = 9 AND MVDATE >= '2018-01-01' and MVTYPE not in ('CM','DS','SM') and MVDATE <= '2018-07-20'
GROUP BY  MVTYPE
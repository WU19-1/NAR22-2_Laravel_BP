UPDATE books
set publication_date = CURRENT_DATE - INTERVAL FLOOR(RAND() * 36500) DAY;
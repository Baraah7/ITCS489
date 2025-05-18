-- First, let's identify the duplicates
CREATE TEMPORARY TABLE duplicate_books AS
SELECT MIN(id) as keep_id, title, author, COUNT(*) as cnt
FROM books
GROUP BY title, author
HAVING COUNT(*) > 1;

-- Update any references to the duplicate books to point to the ones we're keeping
UPDATE order_items oi
JOIN books b ON oi.book_id = b.id
JOIN duplicate_books db ON b.title = db.title AND b.author = db.author
SET oi.book_id = db.keep_id
WHERE b.id != db.keep_id;

-- Now we can safely delete the duplicates
DELETE b FROM books b
JOIN duplicate_books db ON b.title = db.title AND b.author = db.author
WHERE b.id != db.keep_id;

-- Add a unique constraint to prevent future duplicates
ALTER TABLE books ADD CONSTRAINT unique_book UNIQUE (title, author);

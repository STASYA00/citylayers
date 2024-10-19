INSERT INTO `levels`(`aspect_id`, `level`, `config_id`) VALUES 
(1, 1, 1),
(2, 1, 1),
(3, 1, 1),
(4, 1, 1),
(5, 1, 1),
(6, 1, 1);

INSERT INTO `levels`(`aspect_id`, `level`, `config_id`) 
SELECT child_id, 2, 1 
FROM aspect_relations 
WHERE child_id not in (select parent_id from aspect_relations);
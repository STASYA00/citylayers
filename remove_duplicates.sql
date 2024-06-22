with coords as (
select latitude, longitude 
from places 
where id in (
    select place_id from comments
    )),
other as (

select places.id as id from places, coords
where (places.latitude=coords.latitude) AND (places.longitude=coords.longitude)
AND places.id not in (select place_id from comments)
GROUP BY id)

delete from places where id in (select id from other);
;

with ids as (
    select min(id) as id 
    from places 
    group by latitude, longitude

)

delete from places where id not in (
    select id from ids
);
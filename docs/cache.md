# Cache Keys

| Key | Query / Data | TTL | Invalidation | Used In |
|---|---|---|---|---|
| property_types_all | PropertyType::select(id,name)->orderBy(id)->get() | forever | Model: PropertyType saved/deleted | PropertyController@index |

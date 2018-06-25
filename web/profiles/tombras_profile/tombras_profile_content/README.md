# Tombras Profile Content

Docs
https://www.drupal.org/docs/8/modules/default-content

## Install

- Install site using Tombras Profile
- Enable module tombras_profile_content
- After content is imported, disable modules
  - tombras_profile_content
  - default_content


## Add Entities 

- Create content on site
- Run drush command, one per entity_id # (replace with nid)
  $ drush dcer node # --folder=profiles/tombras_profile/tombras_profile_content/content

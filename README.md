

JWT Support for Empathy Applications
---

Add and configure plugin by adding to your global `config.yml` file.  


    plugins:
    ...
      -
        name: Empathy\ELib\JWT\Plugin
        config: '{ "auth_module": "feeds", "auth_class": "feeds", "auth_method": "auth" }'

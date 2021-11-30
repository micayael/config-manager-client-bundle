Config Manager Client
===========

Obtiene los parámetros y configuraciones de aplicaciones consumidoras desde
el repositorio centro de la aplicación Config Manager

Instalación
-----------

~~~
composer require config-manager/client-bundle
~~~

Configuraciones
---------------

Agregar el archivo config_manager_client.yaml en la carpeta config/packages

~~~
config_manager_client:
  host: '%env(resolve:CONFIG_MANAGER_HOST)%'
  app_token: '%env(resolve:CONFIG_MANAGER_APP_TOKEN)%'
~~~

- **host:** url del Config Manager **(requerido)**
- **app_token:** identificador de la aplicación consumidora configurada en el Config Manager **(requerido)**
- **cache:** indica si los parámetros obtenidos deben ser cacheados o no en la aplicación consumidora  **(opcional. default: true)**
- **cache_timeout:** tiempo de cache de los parámetro en la aplicación consumidora **(opcional. default: 86400)**

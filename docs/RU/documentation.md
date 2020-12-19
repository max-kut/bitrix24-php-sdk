Документация по работе с bitrix24-php-sdk
=============================================

## Авторизация на портале

- с использованием [входящих веб-хуков](Core/Auth/auth.md)
- с использованием [OAuth 2.0 токенов](Core/Auth/auth.md#подключение-к-битрикс24-с-использованием-oauth-20)

## Возвращаемые результаты ApiClient

- унифицированный объект [Response](Core/Response/response.md)

## Обработка событий

При работе с SDK могут возникать события, которые требуется обработать в клиентском коде. Библиотека позволяет подписаться на эти события с
помощью компонента `EventDispatcher`
Список [событий](Core/Events/events.md), на которые можно подписаться.

## Отправка запросов в пакетном режиме — batch

- [получение данных](Core/Batch/batch-read-mode.md) в batch-режиме
- запись данных в batch-режиме
- смешанный режим работы

## Сервисы

SDK разбита на сервисы которые соответствуют разрешениям — SCOPE к различным сущностям Битрикс24. Каждый сервис расположен в своём
неймспейсе и предоставляет API по работе с методами из своего пространства имён.

Именно сервис предоставляет CRUD+ API по работе с сущностью.

- im
- imbot
- bizproc
- placement
- user
- entity
- pull
- pull_channel
- mobile
- log
- sonet_group
- telephony
- call
- messageservice
- forum
- pay_system
- mailservice
- userconsent
- rating
- smile
- lists
- delivery
- sale
- timeman
- faceid
- landing
- landing_cloud
- imopenlines
- calendar
- department
- contact_center
- intranet
- documentgenerator
- crm
- task
- tasks_extended
- disk
- catalog
- rpa
- salescenter
- socialnetwork

Точкой входа в неймспейс является билдер сервисов. Например — `CRMServiceBuilder`, который производит конфигурацию конкретных сервисов
отвечающих за работу с CRM.

Сервисы предоставляют CRUD+ API по работе с конкретной сущностью, сервис именуется так же как сущность. Сервис по работе со сделками будет
доступен при вызове `CRM\Deals\Service\Deals`
# Jesse's Practice Application 

## Abstract

This app is made from several smaller ones, each dedicated to a specific task involved in a single aspect of the underlying system. 
The idea here was to mimic micro services.

## Services

### service-discovery

Service discover is what it sounds like... Its responsible for configuring the API tokens and endpoints which the other services will use to talk to each other.

### chirper (blirper)

This sercice simply holds "Blirps", or text messages created by an authenitcated user of the system. It provides a UI as well. Offers standard CRUD operations via an HTTP API schema.

### chirp-board

This service conglomerates all the chrips in the system (that is, residing in the chirper service) and blasts them to a single page for public viewing.

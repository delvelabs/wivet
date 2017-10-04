wivet
=====

Web Input Vector Extractor Teaser

WIVET is a benchmarking project that aims to statistically analyze web link extractors. In general, web application vulnerability scanners fall into this category. These VAs, given a URL(s), try to extract as many input vectors as possibly they can to increase the coverage of the attack surface.

WIVET provides a good sum of input vectors to any extractor and presents the results. In order an input extractor to run meaningfully, it has to provide some kind of session handling, which nearly all of the decent crawlers do. 

Here's the [Cheers List](https://github.com/bedirhan/wivet/wiki/Cheers-List)

## Requirements

docker-compose v.1.15

## Usage

* build the docker containers (one for the wivet code and one for the websocket): `$ docker-compose build`

* run the container: `$ docker-compose up`

* navigate to [localhost:8080](http://localhost:8080)
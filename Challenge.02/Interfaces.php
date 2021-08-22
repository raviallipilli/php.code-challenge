<?php

namespace App\Interfaces;

interface VideoInterface
{
    public function getAudioTrack();
    public function addToWatchList(VideoInterface $video, UserInterface $user);
    public function hasWatched(VideoInterface $video, UserInterface $user);
    public function getRelated();
    public function hasEntitlement(VideoInterface $video, UserInterface $user);
}

/*
An interface comprises of methods that have no content, which means the interface methods are abstract methods.
Every one of the methods in interfaces must have public visibility scope.
Interfaces are not quite the same as classes as the class can inherit from one class but the class can implement one or more interfaces.
No variables cant be present inside interface.
*/
interface SeriesInterface
{
    //
    public function getSeasons();
    public function getSeries();
}

interface EpisodeInterface
{
    //
    public function getEpisodes();
    public function getTotalEpisodes();
}

interface MovieInterface
{
    //
    public function getTrailer();
    public function getGenres();
    public function getSubtitles();
}

// extending the properties of the above interfaces
interface UserInterface extends VideoInterface,SeriesInterface,EpisodeInterface,MovieInterface
{
    public function getRating();
}

// We can achieve multiple inheritances utilizing interface because a class can implement more than one interface whereas it can extend only one class, below is one of the example
class User implements UserInterface 
{
    public function getSeasons() { echo "Get seasons"; }
    public function getAudioTrack() { echo "Get audio tracks"; }
    public function getTrailer() { echo "Get trailors"; }
    public function getGenres() { echo "Get genres"; }
    public function addToWatchList(VideoInterface $video, UserInterface $user){ echo "Get watchlist"; }
    public function getRating() { echo "Get ratings"; }
    public function hasWatched(VideoInterface $video, UserInterface $user){ echo "Get wached list"; }
    public function getRelated() { echo "Get seasons"; }
    public function hasEntitlement(VideoInterface $video, UserInterface $user){ echo "Get entitlemnets"; }
    public function getSubtitles() { echo "Get subtitle"; }
    public function getSeries() { echo "Get series"; }
    public function getEpisodes() { echo "Get episodes"; }
    public function getTotalEpisodes() { echo "Get total episodes"; }
}

// retrieving the data from the class
$u = new User();
echo $u->getAudioTrack()."\n";
echo $u->getTrailer()."\n";
echo $u->getGenres()."\n";
echo $u->getRating()."\n";
echo $u->getRelated()."\n";
echo $u->getSubtitles()."\n";
echo $u->getSeries()."\n";
echo $u->getEpisodes()."\n";
echo $u->getTotalEpisodes()."\n";

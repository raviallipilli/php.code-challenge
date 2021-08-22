<?php

namespace App\Interfaces;

interface VideoInterface
{
    public function getSeasons();
    public function getAudioTrack();
    public function getTrailer();
    public function getGenres();
    public function addToWatchList(VideoInterface $video, UserInterface $user);
    public function getRating();
    public function getEpisodes();
    public function hasWatched(VideoInterface $video, UserInterface $user);
    public function getRelated();
    public function hasEntitlement(VideoInterface $video, UserInterface $user);
    public function getSubtitles();
    public function getTotalEpisodes();
    public function getSeries();
}

interface SeriesInterface
{
    //
}

interface EpisodeInterface
{
    //
}

interface MovieInterface
{
    //
}
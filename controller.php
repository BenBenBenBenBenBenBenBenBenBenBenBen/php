<?php

include "election.php";

class Controller{
    public static function setup(){
        $jsonPath="json/elections.json";
        $jsonString = file_get_contents($jsonPath);
        $ElectionJSON = json_decode($jsonString, true);
        $theElection=new Election($ElectionJSON["Election"]["name"], $ElectionJSON["Election"]["year"]);
        $theElectorate='';
        for ($i=0; $i<=count($ElectionJSON["Parties"])-1; $i++){
            $theElection->addparty($ElectionJSON["Parties"][$i]["name"], $ElectionJSON["Parties"][$i]["seats"]);
            $theElection->setVotePercentage($ElectionJSON["Parties"][$i]["name"], floatval($ElectionJSON["Parties"][$i]["votePercentage"]));
        }
        for ($i=0; $i<=count($ElectionJSON["Electorates"])-1; $i++){
            $theElection->addElectorate($ElectionJSON["Electorates"][$i]["name"]);
            $theElection->setWinningParty($ElectionJSON["Electorates"][$i]["name"], $ElectionJSON["Electorates"][$i]["winningParty"]);
            if ($ElectionJSON["Electorates"][$i]["allMyCandidates"]!=0){
                $theElectorate=$theElection->findElectorate($ElectionJSON["Electorates"][$i]["name"]);
                for ($j=0; $j<=count($ElectionJSON["Electorates"][$i]["allMyCandidates"])-1; $j++){
                    $theElectorate->addCandidate($ElectionJSON["Electorates"][$i]["allMyCandidates"][$j]["candidateName"], $ElectionJSON["Electorates"][$i]["allMyCandidates"][$j]["candidateParty"]);
                    $theElectorate->setCandidateVote($ElectionJSON["Electorates"][$i]["allMyCandidates"][$j]["candidateName"], $ElectionJSON["Electorates"][$i]["allMyCandidates"][$j]["candidateVote"]);
                }
            }
        }
        return $theElection;
    }
}
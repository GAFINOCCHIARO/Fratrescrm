<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class EventCalendarEntity extends Entity
{
    protected $datamap = [];
    protected $dates = ['created_at', 'updated_at', 'deleted_at', 'day_event'];
    protected $times = ['start_time', 'end_time'];
    protected $casts = [];

    // Override del metodo get per gestire la formattazione automatica
    public function __get($name)
    {
        // Se l'attributo esiste nell'entità
        if (array_key_exists($name, $this->attributes)) {
            $value = $this->attributes[$name];

            // Se il campo è definito come data e il valore non è nullo
            if (in_array($name, $this->dates) && !empty($value)) {
                // mi Assicuro che il valore sia una stringa valida per DateTime o un oggetto DateTime
                try {
                    $date = is_string($value) ? new \DateTime($value) : $value;

                    return $date->format('d/m/Y'); // formato italiano
                } catch (\Exception $e) {
                    // Gestione di eventuali errori di formattazione
                    return $value; // Ritorna il valore originale in caso di errore
                }
            }
            if (in_array($name, $this->times) && !empty($value)) {
                try {
                    $time = is_string($value) ? new \DateTime($value) : $value;

                    return $time->format('H:i'); // formato HH:mm per i tempi
                } catch (\Exception $e) {
                    return $value; // Ritorna il valore originale in caso di errore
                }
            }

            return $value; // Ritorna il valore non formattato se non è una data
        }

        return null; // Ritorna null se l'attributo non esiste
    }
}

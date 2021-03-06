<?php

namespace App\Classes;

use DiDom\Document;

/**
 * Class for parsing the content from the page
 */
class ParseLinkPageRentProgressCom
{
    // Page content
    protected $content;
    // Task information
    protected $task;

    /**
     * A builder with the parameters
     *
     * @param string $content
     * @param string $task
     */
    public function __construct($content, $task)
    {
        $this->content = $content;
        $this->task = $task;
    }

    /**
     * Parsing data from $content
     *
     * @return bool
     */
    public function parse()
    {
        $content = new Document($this->content);

        //Info block
        $property_info_block_ul = isset($content->find('div.property-info-block-container')[0]) ?
            $content->find('div.property-info-block-container')[0]->find('ul')[0]->find('li') : '';

        if ($property_info_block_ul) {
            $price = $this->clearText($property_info_block_ul[0]->find('p')[0]->text()); // price
            $beds = $this->clearText($property_info_block_ul[1]->find('p')[0]->text()); // beds
            $bath = $this->clearText($property_info_block_ul[2]->find('p')[0]->text()); // bathrooms
            $sqft = $this->clearText($property_info_block_ul[3]->find('p')[0]->text()); // floor space
            $status = isset($property_info_block_ul[4]) ?
                $this->clearText($property_info_block_ul[4]->find('p')[0]->text()) : ''; // status
        }
        //address
        $addressSection = isset($content->find('section.address-container')[0]) ?
            $content->find('section.address-container')[0]->find('a')[0]->find('span') : '';

        if ($addressSection) {
            $address = [];
            foreach ($addressSection as $as) {
                $address[] = $this->clearText($as->text());
            }

            $fullAddress = implode(', ', $address); // full address
            $street = $address[0];  // str
            $city = explode(',', $address[1])[0]; // city
            $state = explode(' ', explode(',', $address[1])[1])[1]; // state
            $zip = explode(' ', explode(',', $address[1])[1])[2]; // zip
        }
        //Descriptopn
        $description = isset($content->find('div.container-dynamic-info-desc-property')[0]) ?
            $this->clearText($content->find('div.container-dynamic-info-desc-property')[0]->text()) : '';
        //Image
        $imageArr = isset($content->find('section.basic-carousel-image')[0]) ?
            $content->find('section.basic-carousel-image')[0]->find('section img') : '';
        if ($imageArr) {
            $images = [];
            foreach ($imageArr as $image) {
                $images[] = $image->getAttribute('src');
            }
        }
        $images = array_diff($images, ['', null, false]);
        //Amenities
        $allAmenities = isset($content->find('section.amenities-list')[0]) ?
            $content->find('section.amenities-list')[0]->find('div.amenity') : '';
        if ($allAmenities) {
            $listAmenities = [];
            for ($i = 0; $i < count($allAmenities); $i++) {
                $amenity = $allAmenities[$i];

                $title = $this->clearText($amenity->find('h3.amenities-title')[0]->text());
                $tempListAmenities = $amenity->find('div.container-amenities')[0]->find('li');
                $amenities = [];
                foreach ($tempListAmenities as $tla) {
                    $amenities[] = $this->clearText($tla->text());
                }
                /*
                array_push($listAmenities, [
                    'title' => $title,
                    'amenities' => $amenities
                ]);
                */
                array_push($listAmenities, $title . ': ' . implode(', ', $amenities));
            }
        }

        $allAmenitiesText = (!empty($listAmenities)) ? implode(' | ', $listAmenities) : '';
        $description = $description . ' | ' . $allAmenitiesText;

        //move-in-description
        $homeStatus = isset($content->find('div.basic-carousel')[0]->find('div.move-in-description')[0]) ?
            $this->clearText($content->find('div.basic-carousel')[0]->find('div.move-in-description')[0]->text()) : '';
        //Working with the db
        $db = new MySQL();

        $data = [
            // 'price' => $price,
            // 'beds' => $beds,
            // 'bath' => $bath,
            // 'sqft' => $sqft,
            // 'status' => $status,
            'address' => $fullAddress,
            'addr_line_1' => $street,
            'city' => $city,
            'state_cd' => $state,
            'zip5_cd' => $zip,
            'property_info' => $description,
            // 'home_status' => $homeStatus,
            'link' => $this->task['link'],
            'longitude' => $this->task['location']['lng'],
            'latitude' => $this->task['location']['lat'],
            'image_urls' => json_encode($images)
        ];

        // Updating or creating the record in properties
        $idRental = $db->updateOrCreate('properties', $data);

        // Checking for update
        if ($idRental[1] === 'update') {
            $db->deleteAvailability($idRental[0]);
        }

        if ($idRental[0]) {
            $propId = $idRental[0];
            $query = $db->pdo->prepare("INSERT INTO `availability` (
                `property_id`,
                `bedroom_cnt`,
                `bathroom_cnt`,
                `listing_price`,
                `home_size_sq_ft`,
                `status`
            ) VALUES (?, ?, ?, ?, ?, ?)");
            $query->execute([
                $propId,
                $beds,
                $bath,
                $price,
                $sqft,
                $status
            ]);
        }
        // Adding a record into amenities
        /*
        if ($listAmenities) {
            foreach ($listAmenities as $amenity) {
                $db->insert('amenities', [
                    'rent_id' => $idRental[0],
                    'title' => $amenity['title'],
                    'amenities' => json_encode($amenity['amenities'])
                ]);
            }
        } else {
            $db->insert('amenities', [
                'rent_id' => $idRental[0]
            ]);
        }
        */
        // echo 'SUCCESS: ' . $idRental[1] . ' ID: ' . $idRental[0] . PHP_EOL;

        return true;
    }

    /**
     * Cleaning the text
     *
     * @param  string $text
     * @return string
     */
    protected function clearText($text)
    {
        $text = preg_replace('/(?:&nbsp;|\h)+/u', ' ', $text);
        $text = preg_replace('/\h*(\R)\s*/u', '$1', $text);
        $text = trim($text);

        return $text;
    }
}

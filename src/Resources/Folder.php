<?php

namespace Smartsheet\Resources;

use Exception;
use Smartsheet\SmartsheetClient;

class Folder extends Resource
{
    protected SmartsheetClient $client;

    protected string $id;
    protected string $name;
    protected string $permaLink;
    protected array $sheets = [];

    public function __construct($data)
    {
        parent::__construct($data);

        $this->client = resolve(SmartsheetClient::class);
    }

    /**
     * @return string
     */
    public function getPermaLink()
    {
        return $this->permaLink;
    }

    /**
     * @return array
     */
    public function getSheets()
    {
        return $this->sheets;
    }

    /**
     * Fetches the sheet if it exists
     * @param string $name
     * @return string $id
     * @throws Exception
     */
    public function getSheetId(string $name)
    {
        $sheet = collect($this->sheets)
            ->first(function ($sheet) use ($name) {
                return $sheet->name === $name;
            });

        if (is_null($sheet)) {
            throw new Exception('Sheet does not exist.');
        }

        return $sheet->id;
    }

    /**
     * Fetches the sheet if it exists
     * @param string $name
     * @return Sheet $sheet
     * @throws Exception
     */
    public function getSheet(string $name)
    {
        return $this->client->getSheet($this->getSheetId($name));
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }
}
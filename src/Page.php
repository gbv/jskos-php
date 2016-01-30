<?php
namespace JSKOS;

require_once 'Data.php';

/**
 * A list of records in a possibly larger result set.
 */
class Page extends Data {
    public $records;    /**< array */
    public $pageNum;    /**< integer */
    public $pageSize;   /**< integer */
    public $totalCount; /**< integer */

    function __construct($records=[], $pageSize=0, $pageNum=1, $totalCount=0) {
        $this->records  = $records;
        $this->pageNum  = $pageNum;
        $this->pageSize = $pageSize;

        $count = count($records);

        $totalCount = max($totalCount, ($pageNum-1)*$pageSize + $count);
        $this->totalCount = $totalCount;

        if ($pageSize == 0) {
            if ($pageNum == 1) {
                $pageSize = max($pageSize, $count);
            } elseif($count > $pageSize) {
                $records = array_slice($records, 0, $pageSize);
            } 
        }
    }

    public function prevPage() {
        return $this->pageNum - 1;
    }

    public function nextPage() {
        if ($this->totalCount > $this->pageNum*$this->pageSize) {
            return $this->pageNum+1;
        } else {
            return 0;
        }
    }

    public function lastPage() {
        return (int)($this->totalCount / $this->pageSize);
    }


    public function jsonSerialize() {
        return $this->records;
    }
}

?>

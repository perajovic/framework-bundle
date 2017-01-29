<?php 

/*
 * This file is part of the Filos FrameworkBundle project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 * (c) Pera Jovic <perajovic@me.com>. All rights reserved.
 */
declare(strict_types=1);

namespace Tests\Filos\FrameworkBundle\Utils;

use Filos\FrameworkBundle\TestCase\TestCase;
use Filos\FrameworkBundle\Utils\Secret;

class SecretTest extends TestCase
{
    /**
     * @var Secret
     */
    private $secret;

    protected function setUp()
    {
        parent::setUp();

        $this->secret = new Secret('key_123asasdsad', 'iv_456klalkasdmlkasmdlkmasldk');
    }

    /**
     * @test
     * @dataProvider provideString
     */
    public function stringIsEncryptedAndDecrypted(string $string)
    {
        $encrypted = $this->secret->encrypt($string);
        $expected = $this->secret->decrypt($encrypted);

        $this->assertSame($expected, $string);
    }

    public function provideString(): array
    {
        return [
            ['This is some string'],
            ['{"foo":"bar"}'],
            ['{"foo":"bar"}'],
            ['[{"_id":"588e13fccf74007ce8aaf919","index":0,"guid":"4f66d2ab-9a09-45db-8e42-d54402912a6d","isActive":false,"balance":"$1,247.28","picture":"http://placehold.it/32x32","age":35,"eyeColor":"brown","name":"Cotton Richard","gender":"male","company":"MANGELICA","email":"cottonrichard@mangelica.com","phone":"+1 (979) 509-3071","address":"958 Agate Court, Faywood, Pennsylvania, 8287","about":"Enim nostrud et consequat et aliquip dolore tempor proident irure sint non esse ipsum. Irure incididunt Lorem ad enim enim deserunt. Non duis et et nisi ea tempor nisi reprehenderit magna. Ea fugiat commodo amet nisi elit tempor non deserunt nisi elit in adipisicing exercitation.\r\n","registered":"2016-02-02T07:18:09 -01:00","latitude":-7.485256,"longitude":157.527072,"tags":["proident","incididunt","esse","sit","duis","consectetur","irure"],"friends":[{"id":0,"name":"Felicia Good"},{"id":1,"name":"Leola Goodman"},{"id":2,"name":"Brady Oneill"}],"greeting":"Hello, Cotton Richard! You have 5 unread messages.","favoriteFruit":"apple"},{"_id":"588e13fc2011669ef7d46cf7","index":1,"guid":"a06e9277-160c-4548-a56c-393265b6975f","isActive":true,"balance":"$1,843.48","picture":"http://placehold.it/32x32","age":21,"eyeColor":"brown","name":"Mindy Cotton","gender":"female","company":"SYNKGEN","email":"mindycotton@synkgen.com","phone":"+1 (913) 530-2555","address":"237 Caton Avenue, Gibbsville, Idaho, 6667","about":"Duis proident incididunt ea veniam veniam irure consectetur incididunt occaecat ullamco voluptate. Occaecat incididunt tempor labore deserunt exercitation culpa velit eiusmod consequat. Ea dolore ullamco sint incididunt reprehenderit. Mollit dolore eiusmod do sit et qui amet enim tempor do officia amet. Aute ullamco sunt esse minim id proident ea dolore nostrud enim magna quis cillum. Tempor elit deserunt non incididunt sit.\r\n","registered":"2015-03-21T02:20:34 -01:00","latitude":23.893181,"longitude":-59.780621,"tags":["culpa","exercitation","nisi","in","nulla","deserunt","cupidatat"],"friends":[{"id":0,"name":"Tabatha Mcdowell"},{"id":1,"name":"Rosalind Hughes"},{"id":2,"name":"Pugh Mcleod"}],"greeting":"Hello, Mindy Cotton! You have 3 unread messages.","favoriteFruit":"apple"},{"_id":"588e13fc787fd1a61ae84dc8","index":2,"guid":"da074df8-2a96-4317-b6f0-fd52fc13082a","isActive":true,"balance":"$1,813.55","picture":"http://placehold.it/32x32","age":32,"eyeColor":"green","name":"Dominique Rowe","gender":"female","company":"COGENTRY","email":"dominiquerowe@cogentry.com","phone":"+1 (941) 465-2799","address":"511 Varick Avenue, Interlochen, South Dakota, 4789","about":"Quis laborum dolor minim laboris non labore laborum ut dolore consectetur cillum. Eu est dolor duis velit laborum esse eu consequat veniam eu cupidatat eiusmod ullamco. Occaecat adipisicing nulla eiusmod laboris. Lorem ex occaecat veniam est ex esse ullamco. Adipisicing fugiat nostrud anim ad excepteur dolore reprehenderit consectetur est commodo eiusmod ipsum. Sunt laboris veniam anim aute magna tempor.\r\n","registered":"2016-11-01T03:04:30 -01:00","latitude":4.0992,"longitude":-59.806624,"tags":["reprehenderit","mollit","sint","velit","adipisicing","ex","ex"],"friends":[{"id":0,"name":"Rena Armstrong"},{"id":1,"name":"Little Robertson"},{"id":2,"name":"Cantrell Riley"}],"greeting":"Hello, Dominique Rowe! You have 6 unread messages.","favoriteFruit":"apple"},{"_id":"588e13fcee3b0f531543861d","index":3,"guid":"22a2c823-a90f-46f9-b6f1-655c13a5819f","isActive":true,"balance":"$3,833.44","picture":"http://placehold.it/32x32","age":33,"eyeColor":"brown","name":"Alvarado Harvey","gender":"male","company":"EARWAX","email":"alvaradoharvey@earwax.com","phone":"+1 (912) 595-2305","address":"867 Irwin Street, Drummond, Oregon, 6038","about":"Pariatur aute commodo magna voluptate anim ea commodo eiusmod adipisicing ipsum. Amet reprehenderit est esse eu. Exercitation ea culpa sunt consequat in.\r\n","registered":"2016-08-17T11:54:34 -02:00","latitude":-43.013841,"longitude":-110.174599,"tags":["elit","ut","elit","consectetur","consequat","enim","quis"],"friends":[{"id":0,"name":"Kimberly Farmer"},{"id":1,"name":"Mosley Carson"},{"id":2,"name":"Marianne Gay"}],"greeting":"Hello, Alvarado Harvey! You have 3 unread messages.","favoriteFruit":"apple"},{"_id":"588e13fca1e35cfaa8a99c4e","index":4,"guid":"eecc61cf-0147-463c-b3b9-f45817c77ffc","isActive":false,"balance":"$3,166.01","picture":"http://placehold.it/32x32","age":39,"eyeColor":"green","name":"Nielsen Holt","gender":"male","company":"BUZZOPIA","email":"nielsenholt@buzzopia.com","phone":"+1 (950) 442-3536","address":"840 Perry Place, Groton, District Of Columbia, 5244","about":"Sint velit proident aliqua qui elit reprehenderit nostrud id nulla laboris. Laborum irure duis do et et sint sit laborum proident labore anim laborum sunt ex. Sint eiusmod cillum mollit sit non.\r\n","registered":"2015-08-01T10:31:17 -02:00","latitude":84.436885,"longitude":141.67848,"tags":["ad","veniam","sit","sint","eu","deserunt","aute"],"friends":[{"id":0,"name":"Maddox Zimmerman"},{"id":1,"name":"Angelita Goff"},{"id":2,"name":"Fox Fields"}],"greeting":"Hello, Nielsen Holt! You have 3 unread messages.","favoriteFruit":"banana"}]'],
        ];
    }
}

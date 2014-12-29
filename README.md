Magic-Chess
===========

About the Game:

OVERVIEW

Magic chess is a multi-player online turn-based game which is played on a chessboard consisting of 32
squares: four rows and eight columns. In the game, one player plays with the red pieces, and the other
player plays with the black pieces.
At the start of the game the 32 chess pieces are ‘flipped over’ and randomly placed on the board. Don’t
think of them as traditional chess pieces, but as chips with two sides. To win the game, players need to
turn over the pieces and capture all of the opponent’s chessmen.

GAME
There are two systems in this game: Lobby system and Chess game system.

LOBBY SYSTEM
 Players can join the lobby room by accessing a specific http address.
 There are three tables in the game lobby.
 Players can join a game by clicking any table.
 Only two players are allowed to play a game for each table, two icons will be showed on the table.

GAME SYSTEM
Piece Flipping:
To turn over a piece, the player left clicks it with the mouse. Then the piece will change from dark
brown to the corresponding red or black piece.
Chess Pieces:
The turn-based chess game has two sides: red and black. Each side holds 16 pieces which consist of
one King, two advisers, two bishops, two rooks, two knights, two cannons, and five pawns.
One side in total 16

IN-GAME RULES
Preliminary rules:
 This is a turn-based type game.
 The game starts with all pieces flipped over.
 The pieces will be placed randomly on the chessboard, consisting of 32 squares: eight rows and
four columns.
 The player who joined the table first can move first.
 The game will start when both players click the start button.
Actions in one turn:
 Players can click to turn over any flipped piece on board.
 Players can move any of their chessmen on the board.
 Players can capture any opponent’s piece according to capture rules.
Capture rules:
 The chessman to be captured must be in an adjacent square horizontally or vertically.
 In the game, the hierarchy of pieces is:
King > Adviser > Bishop > Rook > Knight > Cannon > Pawn.
 Pieces in the higher position can capture lower piece, except:
o Only Pawn is able to capture King.
o A chessman is able to capture the same chessman, for instance King can capture King.

Capturing:
To capture an opponents’ piece, the player left clicks his own piece. The piece will be displayed in a
selected state (invert colors or outline it). Then players left click the target piece, the target piece
disappears and is replaced by the attacking piece if the capture rules allow it. Otherwise the initial
piece is deselected and the player can try again until his turn is finished.

Capture List:
King can capture King, Adviser, Bishop, Rook, Knight, Cannon, Pawn
Adviser can capture Adviser, Bishop, Rook, Knight, Cannon, Pawn
Bishop can capture Bishop, Rook, Knight, Cannon, Pawn
Rook can capture Rook, Knight, Cannon, Pawn
Knight can capture Knight, Cannon, Pawn
Cannon can capture Cannon, Pawn
Pawn can capture Pawn, King

Piece movement rules:
 Chessmen only can be moved horizontally or vertically between two adjacent squares.
 There are several situations as follows :
Objective square Movable
Is empty 
Is own piece Unmovable
Is flipped piece Unmovable
Your chessman > = Opponent’s chessman Movable
Your chessman < Opponent’s chessman Unmovable
To move a piece, the player left clicks it. The piece will be displayed in a selected state (blurred). Then
players move the piece by left clicking mouse again at the target square.

Turn-based rules:
 When it’s a player’s turn, he can either choose to flip over a piece, move a piece, or capture an
opponent’s piece.

End game rules:
 All of one player’s pieces are captured by his opponent.
 When player disconnects with server during the game, the game will end.

Installation:
Unzip all files to public folder of your webserver.

Usage:
Point separate browsers e.g. chrome / firefox to application's root_directory/php/signup.php.
First screen is the login screen
Then comes lobby, just click on any of tables, you will be able to click only once.
When 2 players will join same table you'll be directed to game start screen.
A common game Board is shared between two persons to play.
Improvements:
There is a lot of room for improvements
- Lockes can be implemented for players to control gameplay, e.g. player1 has only access to red units
etc.
- Chat feature can be implemented
- Gameplay can be improved by introducing Socket servers instead of long polling.
- Caching is still to be implemented.

